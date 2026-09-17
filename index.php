<?php
// ------------------------------------------------------------------------------
//    入口ゲート（2026-09）
//        index.php
//    起動時に DB 接続をチェックし、
//      ・接続OK   → ログイン画面 swUserLogin.html
//      ・接続NG   → 初期設定画面 swSetup.php（DB接続情報を入力・保存）
// ------------------------------------------------------------------------------
	//定数読み込み（$dbHost 等を設定）
	include_once("./sw_config/swConstant.php");
	//接続チェック（exit しない）
	include_once("./include/swDbCheck.php");

	if (swDbCheck_Current()) {
		header("Location: ./swUserLogin.html");
	} else {
		header("Location: ./swSetup.php");
	}
	exit();
?>
