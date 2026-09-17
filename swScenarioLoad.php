<?php
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//     旧バージョンから移植
//
//     swScenarioLoad.php
// -----------------------------------------------------------
//
//		Scenario_index.cgi(sjis)
//			├シナリオフォルダ
//				├character.cgi(sjis)
//				├scene.cgi(sjis)
//				├synop.cgi(sjis)
//				├scenario.cgi(sjis)
//
// ------------------------------------------------------------------------------
	//定数読み込み
	include_once("./sw_config/swConstant.php");
	//DB接続ｸﾗｽの初期化
	include_once("./include/ConnectMySQL.php");
// ------------------------------------------------------------------------------
	//共通関数をｲﾝｸﾙｰﾄﾞ
	include_once("./include/swFunc.php");
	
	// ﾍｯﾀﾞ表示
	$HtmlTitle = "シナリオ移植";
	include_once("./include/swHeader.php");

	//処理時間無制限
	$ret = set_time_limit(0);
	
	$strSQL = <<<END_OF_SQL

			LOAD DATA LOCAL INFILE './scenario_folder/scenario_lines.csv' INTO TABLE SW_SCENARIO_LINES
				FIELDS TERMINATED BY ',' ENCLOSED BY '"';
END_OF_SQL;
	
	//SQL Execute 
	$myResult = $mySqlConnObj->query($strSQL);

	echo"myResult = $myResult";

	exit();


// -----------------------------------------------------------
?>