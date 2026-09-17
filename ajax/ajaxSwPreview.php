<?php
// ------------------------------------------------------------------------------
//    劇団員プレビューの公開設定 I/O（2026-09）
//        ajaxSwPreview.php
//    POST: fdtUserLoginId, fdtScenarioId, SubMode = Status | Enable | Disable | Regenerate
//    返却 JSON: {ok, valid, url, message}
//    ログインIDのユーザーがそのシナリオの持ち主であることを確認する
// ------------------------------------------------------------------------------
	include_once("../sw_config/swConstant.php");
	include_once("../include/ConnectMySQL.php");
	include_once("../include/swFunc.php");
	include_once("../include/swPreview.php");
	include_once("../class/clsSwUserLoginInfo.php");
	include_once("../class/clsSwScenario.php");
	header('Content-Type: application/json; charset=UTF-8');

	function out($ok, $valid, $url, $msg){ echo json_encode(array('ok'=>(bool)$ok, 'valid'=>(int)$valid, 'url'=>$url, 'message'=>$msg), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); exit(); }

	$SubMode = swFunc_GetPostData('SubMode');
	$loginId = swFunc_GetPostData('fdtUserLoginId');
	$scenarioId = (int)swFunc_GetPostData('fdtScenarioId');

	//ログイン → USER_ID
	$li = new clsSwUserLoginInfo();
	$li->clsSwUserLoginInfoInit($mySqlConnObj, $loginId);
	$userId = (int)$li->clsSwUserLoginInfoGetUserId();
	if ($loginId === '' || $userId <= 0) { out(false, 0, '', 'ログインしてください。'); }
	//シナリオの持ち主か
	$sc = new clsSwScenario();
	$sc->clsSwScenarioInit($mySqlConnObj, $scenarioId);
	if ($scenarioId <= 0 || (int)$sc->clsSwScenarioGetUserId() !== $userId) { out(false, 0, '', 'このシナリオは操作できません。'); }

	switch ($SubMode) {
		case 'Enable':
			$key = swPreview_Enable($mySqlConnObj, $scenarioId);
			out(true, 1, swPreview_Url($key), '公開しました。URL を劇団員に伝えてください。');
		case 'Regenerate':
			$key = swPreview_Enable($mySqlConnObj, $scenarioId, true);
			out(true, 1, swPreview_Url($key), 'URL を作り直しました。以前の URL は使えません。');
		case 'Disable':
			swPreview_Disable($mySqlConnObj, $scenarioId);
			out(true, 0, '', '公開を停止しました。');
		case 'Status':
		default:
			$cur = swPreview_Get($mySqlConnObj, $scenarioId);
			out(true, $cur['valid'], $cur['valid'] ? swPreview_Url($cur['key']) : '', '');
	}
?>
