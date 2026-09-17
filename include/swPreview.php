<?php
// ------------------------------------------------------------------------------
//
//    劇団員プレビュー（2026-09 追加）
//        swPreview.php（include）
//
//    Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//    脚本家がシナリオ情報画面で「公開」すると、推測できない鍵（32桁の16進）付きの URL が発行され、
//    ログインなしで swPreview.php?k=鍵 からシナリオを読める。停止すれば同じ URL は開けなくなる。
//    鍵は SW_PREVIEW 表に持つ。表が無い既存 DB には初回に自動作成する（SQLite / MySQL 両対応）。
//
// ------------------------------------------------------------------------------

// SW_PREVIEW 表が無ければ作る（インストール済みの DB にも後から入れられるように）
function swPreview_EnsureTable($db){
	static $done = false;
	if ($done) { return; }
	$done = true;
	$driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME);
	if ($driver === 'sqlite') {
		$sql = "CREATE TABLE IF NOT EXISTS SW_PREVIEW (
			SCENARIO_ID INTEGER NOT NULL PRIMARY KEY,
			PREVIEW_KEY VARCHAR(64) NOT NULL,
			PREVIEW_VALID INTEGER NOT NULL DEFAULT 0,
			UPDATE_DATE TEXT NOT NULL DEFAULT (datetime('now','localtime'))
		)";
	} else {
		$sql = "CREATE TABLE IF NOT EXISTS SW_PREVIEW (
			SCENARIO_ID int(11) NOT NULL COMMENT 'シナリオID',
			PREVIEW_KEY varchar(64) NOT NULL COMMENT '公開URLの鍵',
			PREVIEW_VALID int(11) NOT NULL DEFAULT 0 COMMENT '1=公開中',
			UPDATE_DATE timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
			PRIMARY KEY (SCENARIO_ID),
			KEY SW_PREVIEW_KEY_PREVIEW_KEY (PREVIEW_KEY)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='劇団員プレビュー'";
	}
	try { $db->exec($sql); } catch (Exception $e) { error_log('swPreview_EnsureTable: ' . $e->getMessage()); }
}

// 新しい鍵
function swPreview_NewKey(){
	if (function_exists('random_bytes')) { return bin2hex(random_bytes(16)); }
	return bin2hex(openssl_random_pseudo_bytes(16));
}

// シナリオの公開状態 array(valid=>0|1, key=>string) 。行が無ければ valid=0, key=''
function swPreview_Get($db, $scenarioId){
	swPreview_EnsureTable($db);
	$st = $db->prepare("SELECT PREVIEW_KEY, PREVIEW_VALID FROM SW_PREVIEW WHERE SCENARIO_ID = :s");
	$st->bindValue(':s', (int)$scenarioId, PDO::PARAM_INT);
	$st->execute();
	$row = $st->fetch(PDO::FETCH_ASSOC);
	if (!$row) { return array('valid' => 0, 'key' => ''); }
	return array('valid' => (int)$row['PREVIEW_VALID'], 'key' => (string)$row['PREVIEW_KEY']);
}

// 公開する（鍵が無ければ発行）。鍵を返す
function swPreview_Enable($db, $scenarioId, $regenerate = false){
	$cur = swPreview_Get($db, $scenarioId);
	$key = ($cur['key'] === '' || $regenerate) ? swPreview_NewKey() : $cur['key'];
	$now = date('Y-m-d H:i:s');
	if ($cur['key'] === '') {
		$st = $db->prepare("INSERT INTO SW_PREVIEW (SCENARIO_ID, PREVIEW_KEY, PREVIEW_VALID, UPDATE_DATE) VALUES (:s, :k, 1, :d)");
	} else {
		$st = $db->prepare("UPDATE SW_PREVIEW SET PREVIEW_KEY = :k, PREVIEW_VALID = 1, UPDATE_DATE = :d WHERE SCENARIO_ID = :s");
	}
	$st->bindValue(':s', (int)$scenarioId, PDO::PARAM_INT);
	$st->bindValue(':k', $key, PDO::PARAM_STR);
	$st->bindValue(':d', $now, PDO::PARAM_STR);
	$st->execute();
	return $key;
}

// 停止する（鍵は残すので再公開時は同じ URL。作り直したいときは Enable(…, true)）
function swPreview_Disable($db, $scenarioId){
	swPreview_EnsureTable($db);
	$st = $db->prepare("UPDATE SW_PREVIEW SET PREVIEW_VALID = 0, UPDATE_DATE = :d WHERE SCENARIO_ID = :s");
	$st->bindValue(':s', (int)$scenarioId, PDO::PARAM_INT);
	$st->bindValue(':d', date('Y-m-d H:i:s'), PDO::PARAM_STR);
	$st->execute();
}

// 鍵から公開中のシナリオIDを返す。無効なら 0
function swPreview_FindByKey($db, $key){
	if (!preg_match('/^[0-9a-f]{32}$/', (string)$key)) { return 0; }
	swPreview_EnsureTable($db);
	$st = $db->prepare("SELECT SCENARIO_ID FROM SW_PREVIEW WHERE PREVIEW_KEY = :k AND PREVIEW_VALID = 1");
	$st->bindValue(':k', $key, PDO::PARAM_STR);
	$st->execute();
	$row = $st->fetch(PDO::FETCH_ASSOC);
	return $row ? (int)$row['SCENARIO_ID'] : 0;
}

// このサイトのルート URL（swFunc_BaseUrl と同じ）
function swPreview_BaseUrl(){
	include_once(__DIR__ . '/swFunc.php');
	return swFunc_BaseUrl();
}

function swPreview_Url($key){
	return swPreview_BaseUrl() . 'swPreview.php?k=' . $key;
}

// ------------------------------------------------------------------------------
//   シナリオ本文の HTML（閲覧ページ用）。array(title, subtitle, writer, html) を返す
//   ・ユーザーのスタイル設定（文字色・字下げ・省略文字・名前の表示/「」）を反映
//   ・字下げは padding-inline-start で書く（縦書きでも横書きでも「行頭側」に効く）
// ------------------------------------------------------------------------------
function swPreview_Render($db, $scenarioId){
	include_once(__DIR__ . '/../class/clsSwScenario.php');
	include_once(__DIR__ . '/../class/clsSwUserOption.php');
	include_once(__DIR__ . '/../class/clsSwSynopsis.php');
	include_once(__DIR__ . '/swFunc.php');

	$sc = new clsSwScenario();
	$sc->clsSwScenarioInit($db, $scenarioId);
	$title    = swFunc_SanitizeStrings($sc->clsSwScenarioGetScenarioTitle());
	$subtitle = swFunc_SanitizeStrings($sc->clsSwScenarioGetScenarioSubtitle());
	$writer   = swFunc_SanitizeStrings($sc->clsSwScenarioGetScenarioWriterName());
	$userId   = (int)$sc->clsSwScenarioGetUserId();

	//「」で囲むかのオプション、スタイル
	swFunc_LoadKagikakkoOption($db, $scenarioId);
	$opt = new clsSwUserOption();
	$styles = $opt->fncGetUserOptionStyle($db, $userId);

	//登場人物（一覧と、ID→名前）
	$chars = array();
	$st = $db->prepare("SELECT CHARACTER_ID, CHARACTER_NAME, CHARACTER_CHARA FROM SW_CHARACTER WHERE SCENARIO_ID = :s ORDER BY CHARACTER_ORDER_NO");
	$st->bindValue(':s', $scenarioId, PDO::PARAM_INT); $st->execute();
	while ($r = $st->fetch(PDO::FETCH_ASSOC)) { $chars[(string)$r['CHARACTER_ID']] = $r; }

	//シノプシス
	$sy = new clsSwSynopsis();
	$sy->clsSwSynopsisInitScenarioId($db, $scenarioId);
	$synopsis = (string)$sy->clsSwSynopsisGetSynopsis();

	$html = '';
	//登場人物
	if (count($chars) > 0) {
		$html .= '<section class="pv-cast"><h2>登場人物</h2><dl>';
		foreach ($chars as $c) {
			$html .= '<div class="pv-cast-row"><dt>' . swFunc_SanitizeStrings($c['CHARACTER_NAME']) . '</dt><dd>' . swPreview_Text($c['CHARACTER_CHARA']) . '</dd></div>';
		}
		$html .= '</dl></section>';
	}
	//シノプシス
	if (trim(str_replace('<br>', '', $synopsis)) !== '') {
		$html .= '<section class="pv-synopsis"><h2>シノプシス</h2><p>' . swPreview_Text($synopsis) . '</p></section>';
	}

	//場面と台詞
	$sceneNo = 0;
	$index = array();
	$st = $db->prepare("SELECT SCENE_ID, SCENE_NAME, SCENE_DESCRIPTION FROM SW_SCENE WHERE SCENARIO_ID = :s ORDER BY SCENE_ORDER_NO");
	$st->bindValue(':s', $scenarioId, PDO::PARAM_INT); $st->execute();
	$scenes = $st->fetchAll(PDO::FETCH_ASSOC);
	$ls = $db->prepare("SELECT SCENARIO_TYPE, CHARACTER_ID, SCENARIO_LINES FROM SW_SCENARIO_LINES WHERE SCENE_ID = :sc ORDER BY SCENARIO_LINES_ORDER_NO");
	foreach ($scenes as $s) {
		$sceneNo++;
		$sceneName = swFunc_SanitizeStrings($s['SCENE_NAME']);
		$index[] = array('id' => 'scene' . $sceneNo, 'name' => $sceneName);
		$html .= '<section class="pv-scene" id="scene' . $sceneNo . '">';
		$html .= '<h2 class="pv-hashira"><span class="pv-scene-no">' . $sceneNo . '</span>' . $sceneName . '</h2>';
		if (trim((string)$s['SCENE_DESCRIPTION']) !== '') {
			$html .= '<p class="pv-scene-desc">' . swPreview_Text($s['SCENE_DESCRIPTION']) . '</p>';
		}
		$ls->bindValue(':sc', $s['SCENE_ID'], PDO::PARAM_INT); $ls->execute();
		while ($l = $ls->fetch(PDO::FETCH_ASSOC)) {
			$html .= swPreview_Line($l, $chars, $styles);
		}
		$html .= '</section>';
	}
	if ($sceneNo === 0) { $html .= '<p class="pv-empty">まだ場面がありません。</p>'; }

	return array('title' => $title, 'subtitle' => $subtitle, 'writer' => $writer, 'html' => $html, 'index' => $index);
}

// DB の本文（<br> 改行）→ 表示用 HTML
function swPreview_Text($s){
	$s = str_replace('<br>', "\n", (string)$s);
	$s = swFunc_SanitizeStrings($s);
	return nl2br($s, false);
}

// 台詞 1 行
function swPreview_Line($l, $chars, $styles){
	$type = (string)$l['SCENARIO_TYPE'];
	$cid  = (string)$l['CHARACTER_ID'];
	$name = isset($chars[$cid]) ? swFunc_SanitizeStrings($chars[$cid]['CHARACTER_NAME']) : '';
	$text = swFunc_RemoveLastStr((string)$l['SCENARIO_LINES'], '。');

	$fontSize = 12; $color = ''; $indent = 0; $str = ''; $word = '0';
	if (isset($styles[$type])) {
		$a = explode(',', $styles[$type]);
		if (isset($a[0]) && $a[0] !== '') { $fontSize = (int)$a[0]; }
		if (isset($a[1])) { $color = $a[1]; }
		if (isset($a[2])) { $indent = (float)$a[2]; }
		if (isset($a[3])) { $str = swFunc_SanitizeStrings($a[3]); }
		if (isset($a[4])) { $word = $a[4]; }
	} else {
		//スタイル未設定のときの既定（1=台詞 2=ト書 3=歌詞）
		if ($type === '1') { $word = '1'; } elseif ($type === '2') { $indent = 3; $color = '#006400'; } elseif ($type === '3') { $str = 'Song'; }
	}
	$showName = ($word === '1' || $word === '2');
	$kagi = ($word === '1' || $word === '3' || (!isset($styles[$type]) && $type === '1'));
	if ($kagi) { $text = swFunc_Kagikakko($text); }
	$label = $showName ? trim($name . ' ' . $str) : $str;

	$cls = 'pv-line pv-type' . (int)$type;
	$style = 'padding-inline-start:' . $indent . 'em;';
	if ($color !== '' && preg_match('/^#?[0-9a-fA-F]{3,6}$|^[a-zA-Z]+$/', $color)) { $style .= 'color:' . $color . ';'; }
	if ($fontSize > 0 && $fontSize != 12) { $style .= 'font-size:' . round($fontSize / 12, 2) . 'em;'; }

	$h = '<div class="' . $cls . '" style="' . $style . '">';
	if ($label !== '') { $h .= '<span class="pv-name">' . $label . '</span>'; }
	$h .= '<span class="pv-text">' . swPreview_Text($text) . '</span></div>';
	return $h;
}
?>
