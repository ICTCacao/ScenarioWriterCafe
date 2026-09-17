<?php
// ------------------------------------------------------------------------------
//
//		PDO で DB に接続（ファイル名は歴史的に ConnectMySQL だが MySQL 以外にも繋ぐ）
//
//		Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//		2026-09 PHP8.3 / MariaDB10.11(utf8mb4) 対応
//		  ・接続文字セットを swConstant.php の _DB_CHARACTER_SET_ (utf8mb4) に
//		  ・$dbSocket があれば unix_socket 接続（ローカルMAMP）、なければ host[:port]（XSERVER）
//		  ・PDO::ATTR_ERRMODE を明示。PHP8 から既定が ERRMODE_EXCEPTION に変わり、
//		    SQL エラーが未捕捉例外＝画面真っ白になる。PHP7 時代の挙動に近い
//		    ERRMODE_WARNING（処理は続行、error_log に残る）にしておく。
//		    ※ 動作が落ち着いたら ERRMODE_EXCEPTION に切り替えて潜在バグを洗う。
//		2026-09 マルチDB対応
//		  ・DSN の組み立てと接続を include/swDb.php に集約。$dbType で mysql / sqlite を切替。
//		  ・ここを include するファイル（約40本）は変更不要。$mySqlConnObj に PDO が入る。
//
// ------------------------------------------------------------------------------
	include_once(__DIR__ . '/swDb.php');
	try {
		$mySqlConnObj = swDb_Connect(swDb_ConfigFromGlobals());
	} catch (PDOException $e) {
			exit('データベース接続失敗。'.$e->getMessage());
	}

?>
