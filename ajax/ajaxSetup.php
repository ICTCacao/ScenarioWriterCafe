<?php
// ------------------------------------------------------------------------------
//    初期設定 I/O（2026-09）
//        ajaxSetup.php
//    action=test : 入力値でDB接続を試す
//    action=save : 接続できたら sw_config/swDbSetting.php に書き出す
//    action=install : テーブル作成＋最初のユーザー登録＋設定保存
//    action=status  : 現在の設定で接続できるか（swUserLogin.html の起動時チェック）
//    返却は JSON: {"ok":bool,"message":string}
//    2026-09 マルチDB対応: dbType（mysql / sqlite）で接続とスキーマを切替（include/swDb.php）
// ------------------------------------------------------------------------------
	include_once("../sw_config/swConstant.php");
	include_once("../include/swDbCheck.php");
	include_once("../include/swFunc.php");
	include_once("../class/clsSwUserOption.php");
	header('Content-Type: application/json; charset=UTF-8');

	function post($k){ return isset($_POST[$k]) ? trim((string)$_POST[$k]) : ''; }
	function swSetup_splitSql($sql){
		//行コメント(--)を除き、; で分割（この配布SQLに ; を含む値は無いため単純分割で足りる）
		$lines = preg_split('/\r?\n/', $sql);
		$buf = '';
		$stmts = array();
		foreach ($lines as $ln) {
			$t = ltrim($ln);
			if (substr($t,0,2) === '--' || $t === '') { continue; }
			$buf .= $ln . "\n";
			if (rtrim($ln) !== '' && substr(rtrim($ln), -1) === ';') { $stmts[] = $buf; $buf = ''; }
		}
		if (trim($buf) !== '') { $stmts[] = $buf; }
		return $stmts;
	}
	function out($ok, $msg){ echo json_encode(array('ok'=>(bool)$ok, 'message'=>$msg), JSON_UNESCAPED_UNICODE); exit(); }

	$action = post('action');

	//action=status : 現在の設定（swConstant が読んだもの）で接続できるかだけ返す。
	//  静的な swUserLogin.html が起動時に呼び、未設定なら swSetup.php へ誘導する。
	if ($action === 'status') {
		out(swDbCheck_Current(), swDbCheck_Current() ? '接続できています' : '未設定');
	}
	$cfg = swDb_NormalizeConfig(array(
		'dbType'   => post('dbType'),
		'dbHost'   => post('dbHost'),
		'dbPort'   => post('dbPort'),
		'dbSocket' => post('dbSocket'),
		'dbName'   => post('dbName'),
		'dbUser'   => post('dbUser'),
		'dbPass'   => post('dbPass'),
		'dbFile'   => post('dbFile'),
	));
	if (!array_key_exists($cfg['dbType'], swDb_Types())) { out(false, "未対応のDB種別です: " . $cfg['dbType']); }

	//設定ファイルの本文（save / install 共通）
	function swSetup_configBody($cfg, $who){
		//PHP単一引用符文字列としてエスケープ
		$esc = function($v){ return str_replace(array('\\', "'"), array('\\\\', "\\'"), (string)$v); };
		$b  = "<?php\n";
		$b .= "// ------------------------------------------------------------------------------\n";
		$b .= "//    DB接続設定（" . $who . " が保存。手で編集も可）  " . date('Y-m-d H:i:s') . "\n";
		$b .= "//    swConstant.php がこのファイルを読み込みます。\n";
		$b .= "//    dbType: mysql（MySQL/MariaDB）| sqlite（dbFile にファイルパス。空なら sw_config/swdata.sqlite）\n";
		$b .= "// ------------------------------------------------------------------------------\n";
		foreach (array('dbType','dbHost','dbPort','dbSocket','dbName','dbUser','dbPass','dbFile') as $k) {
			$b .= "\$" . str_pad($k, 8) . " = '" . $esc($cfg[$k]) . "';\n";
		}
		$b .= "?>\n";
		return $b;
	}

	//設定ファイルを書き、opcache に残った古い内容を捨てる
	//  （opcache は revalidate_freq 秒間は更新を見ないため、書いた直後の status / ログインが旧設定で動いてしまう）
	function swSetup_writeConfig($file, $body){
		$res = @file_put_contents($file, $body);
		if ($res === false) { return false; }
		@chmod($file, 0640);
		if (function_exists('opcache_invalidate')) { @opcache_invalidate($file, true); }
		return true;
	}

	//まず接続テスト（test / save / install 共通）
	//  test / install は「これからインストールする」前提なので、SQLite ファイル未作成・テーブル未作成でも OK 扱い
	//  （save は既存 DB をそのまま使うので厳密に判定）
	list($ok, $msg) = swDbCheck_TryConnect($cfg, $action !== 'save');

	if ($action === 'test') {
		out($ok, $msg);
	}

	if ($action === 'save') {
		if (!$ok) {
			out(false, "接続できないため保存しませんでした: " . $msg);
		}
		$body = swSetup_configBody($cfg, 'swSetup.php');

		$file = __DIR__ . '/../sw_config/swDbSetting.php';
		if (!swSetup_writeConfig($file, $body)) {
			//書き込めない場合は内容を返して手動保存を促す
			out(false, "sw_config/swDbSetting.php に書き込めませんでした。パーミッションを確認するか、次の内容を手動で保存してください:\n\n" . $body);
		}
		out(true, "保存しました。");
	}

	if ($action === 'install') {
		if (!$ok) { out(false, "データベースに接続できません: " . $msg); }
		//生の接続（テーブル有無に関係なく：テーブルが無くてもインストールできるように）
		try {
			$pdo = swDb_Connect($cfg, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		} catch (PDOException $e) {
			out(false, "データベースに接続できません: " . $e->getMessage());
		}

		//管理ユーザーの入力チェック
		$adminMail = post('adminMail');
		$adminPass = post('adminPass');
		$adminPass2 = post('adminPass2');
		if ($adminMail === '' || $adminPass === '') { out(false, "メールアドレスとパスワードを入力してください。"); }
		if (!filter_var($adminMail, FILTER_VALIDATE_EMAIL)) { out(false, "メールアドレスの形式が正しくありません。"); }
		if ($adminPass !== $adminPass2) { out(false, "パスワード（確認）が一致しません。"); }

		//1) スキーマ + 既定スタイル(USER_ID=0) を流す（DB種別ごとのファイル）
		$schemaFile = swDb_SchemaFile($cfg['dbType']);
		$schema = @file_get_contents($schemaFile);
		if ($schema === false) { out(false, "スキーマファイルが読み込めません: sw_config/" . basename($schemaFile)); }
		try {
			foreach (swSetup_splitSql($schema) as $stmt) {
				if (trim($stmt) === '') { continue; }
				$pdo->exec($stmt);
			}
		} catch (PDOException $e) {
			out(false, "テーブル作成に失敗しました: " . $e->getMessage());
		}

		//2) 最初のユーザーを登録（既にあれば作らない）
		try {
			$chk = $pdo->prepare("SELECT USER_ID FROM SW_USER WHERE USER_MAILAD = :m");
			$chk->bindValue(':m', $adminMail);
			$chk->execute();
			$row = $chk->fetch(PDO::FETCH_ASSOC);
			if ($row) {
				$userId = (int)$row['USER_ID'];
			} else {
				$hash = swFunc_Hash($adminMail, $adminPass);   // 保存パスワード = Hash(メール, 平文)
				$name0 = strstr($adminMail, '@', true);
				if ($name0 === false || $name0 === '') { $name0 = 'admin'; }
				$ins = $pdo->prepare("INSERT INTO SW_USER (USER_MAILAD, USER_PASSWD, USER_NAME, USER_MAX_SCENARIO) VALUES (:m, :p, :n, 99999)");
				$ins->bindValue(':m', $adminMail);
				$ins->bindValue(':p', $hash);
				$ins->bindValue(':n', $name0);
				$ins->execute();
				$userId = (int)$pdo->lastInsertId();
			}
			//オプション設定の既定行
			$chkS = $pdo->prepare("SELECT USER_ID FROM SW_USER_OPTION_SETTING WHERE USER_ID = :u");
			$chkS->bindValue(':u', $userId, PDO::PARAM_INT); $chkS->execute();
			if (!$chkS->fetch(PDO::FETCH_ASSOC)) {
				$insS = $pdo->prepare("INSERT INTO SW_USER_OPTION_SETTING (USER_ID, CHARACTER_LENGTH, BODY_LENGTH, USE_KAGIKAKKO) VALUES (:u, 8, 32, 1)");
				$insS->bindValue(':u', $userId, PDO::PARAM_INT); $insS->execute();
			}
			//既定スタイル(USER_ID=0)を複写
			$opt = new clsSwUserOption();
			$opt->clsSwUserOptionSetDefault($pdo, $userId);
		} catch (PDOException $e) {
			out(false, "ユーザー登録に失敗しました: " . $e->getMessage());
		}

		//3) 接続情報を保存
		$bodyCfg = swSetup_configBody($cfg, 'swSetup.php インストール');
		$cfgFile = __DIR__ . '/../sw_config/swDbSetting.php';
		if (!swSetup_writeConfig($cfgFile, $bodyCfg)) {
			out(false, "設定は作成できましたが sw_config/swDbSetting.php に書き込めません。手動で保存してください:\n\n" . $bodyCfg);
		}
		if ($cfg['dbType'] === 'sqlite') { @chmod(swDb_SqlitePath($cfg['dbFile']), 0660); }
		out(true, "インストール完了（" . swDb_Types()[$cfg['dbType']] . "）。ログイン画面から入れます。");
	}

	out(false, "不明な操作です。");
?>
