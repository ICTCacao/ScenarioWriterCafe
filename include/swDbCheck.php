<?php
// ------------------------------------------------------------------------------
//    DB接続チェック共通（2026-09 追加）
//        swDbCheck.php
//    swConstant.php の後に読み込む。exit せず true/false を返す接続テストを提供。
//    2026-09 マルチDB対応: 設定は配列（dbType, dbHost, dbPort, dbSocket, dbName, dbUser, dbPass, dbFile）
// ------------------------------------------------------------------------------
	include_once(__DIR__ . '/swDb.php');

// 指定値で接続を試す。array(bool $ok, string $message) を返す。
//   $cfg: swDb_NormalizeConfig() が受け付ける配列
//   $forInstall: true ならテーブル未作成でも「接続できた」とみなす（インストール前の確認用）
function swDbCheck_TryConnect($cfg, $forInstall = false){
	$cfg = swDb_NormalizeConfig($cfg);
	try {
		if ($cfg['dbType'] === 'sqlite') {
			//SQLite は開いた時点でファイルが作られる。テスト目的では作らない。
			$path = swDb_SqlitePath($cfg['dbFile']);
			if (!is_file($path)) {
				if ($forInstall) {
					$dir = dirname($path);
					if (!is_dir($dir) || !is_writable($dir)) {
						return array(false, "SQLite ファイルを作れません。フォルダに書込権限がありません: " . $dir);
					}
					return array(true, "SQLite は使えます（PHP に同梱。別途インストール不要）。DB ファイルはまだ無く、「インストール」で作成されます: " . $path);
				}
				return array(false, "SQLite ファイルがありません: " . $path . "（インストールで作成されます）");
			}
			if (!is_writable($path)) {
				return array(false, "SQLite ファイルに書き込めません（パーミッション）: " . $path);
			}
		}
		$pdo = swDb_Connect($cfg, array(
			PDO::ATTR_TIMEOUT => 4,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		));
		// 主要テーブルの有無も軽く確認（DBはあるが未インポートの検出）
		$hasTable = false;
		try {
			$pdo->query("SELECT 1 FROM SW_USER LIMIT 1");
			$hasTable = true;
		} catch (PDOException $e) {
			$hasTable = false;
		}
		if (!$hasTable) {
			if ($forInstall) { return array(true, "接続成功。テーブルはまだ無く、「インストール」で作成されます。"); }
			return array(false, "接続はできましたが、テーブル(SW_USER 等)が見つかりません。インストール（またはDBダンプのインポート）が必要です。");
		}
		return array(true, "接続成功");
	} catch (PDOException $e) {
		return array(false, $e->getMessage());
	}
}

// 現在の swConstant 設定で接続できるか（グローバル $dbType, $dbHost 等を使用）
function swDbCheck_Current(){
	$r = swDbCheck_TryConnect(swDb_ConfigFromGlobals());
	return $r[0];
}
?>
