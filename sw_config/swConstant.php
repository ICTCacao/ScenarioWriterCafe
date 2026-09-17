<?php
// ------------------------------------------------------------------------------
//
//    System Constant
//        swConstant.php
//
//    Copyright(C) 2015 ScenarioWriterCafe Released under the MIT License (see LICENSE).
//
//    2026-09 PHP8.3 / MariaDB10.11(utf8mb4) 対応
//      ・mb_http_input("auto") を削除（PHP8 では ValueError で全ページが即死する）
//      ・DB文字セットを utf8mb4 に
//      ・ローカル開発用の上書きファイル swLocalConfig.php（本番には置かない）
//
// ------------------------------------------------------------------------------

//ローカル開発用の上書き（MAMP 等）。本番サーバにはこのファイルを置かない。
//  ここで DEBUG_MODE / $dbHost / $dbSocket 等を先に定義しておくと下の既定値より優先される。
if (is_file(__DIR__ . '/swLocalConfig.php')) {
	include_once(__DIR__ . '/swLocalConfig.php');
}

//設定画面 swSetup.php が書き出す DB 接続設定（あれば読み込む）。
//  優先順位: swLocalConfig（ローカル開発）→ swDbSetting（設定画面が保存）→ 下の既定値。
if (is_file(__DIR__ . '/swDbSetting.php')) {
	include_once(__DIR__ . '/swDbSetting.php');
}

//ﾃﾞﾊﾞｯｸﾞ
if (!defined('DEBUG_MODE')) {
	define("DEBUG_MODE",FALSE);
}

//エラー表示
//  PHP8 では「Undefined index / variable」が Notice から Warning に上がる。
//  画面（特に ajax の HTML 断片やダウンロードのバイナリ）に警告文が混入しないよう
//  本番では表示せずログに残す。ローカルは DEBUG_MODE=TRUE で表示する。
error_reporting(E_ALL);
ini_set('display_errors', DEBUG_MODE ? '1' : '0');
ini_set('log_errors', '1');

//内部文字コードを変更
mb_language("uni");
mb_internal_encoding("utf-8");
//mb_http_input("auto");  ← PHP8 では引数 "auto" が不正で ValueError。HTTP入力の自動変換は元々効いていないため削除。
mb_http_output("utf-8");

//Timezone
date_default_timezone_set('Asia/Tokyo');

//DB Connect
//  $dbType: sqlite（標準。ファイル1個。$dbFile にパス。空なら sw_config/swdata.sqlite）または mysql（MySQL/MariaDB）
//    2026-09 標準を SQLite に変更。$dbType 未指定でも旧設定（$dbName あり）なら mysql とみなす（互換）。
//  XSERVER 本番: $dbHost は「サーバーパネル > MySQL設定」の MySQL ホスト名（例 mysqlXXXX.xserver.jp）
//                DB名・ユーザー名はサーバーIDのプレフィックス付き（例 cacao2_swdb / cacao2_swuser）
//  ローカル MAMP: swLocalConfig.php で $dbSocket を指定する
//  配布状態では未設定（空）。初回アクセス時は接続に失敗し、初期設定画面 swSetup.php へ誘導される。
//  設定は swSetup.php から sw_config/swDbSetting.php に保存される（または swLocalConfig.php をローカルで置く）。
if (!isset($dbType))   { $dbType = (isset($dbName) && $dbName !== "") ? "mysql" : "sqlite"; }
if (!isset($dbFile))   { $dbFile = ""; }
if (!isset($dbHost))   { $dbHost = "localhost"; }
if (!isset($dbPort))   { $dbPort = ""; }
if (!isset($dbSocket)) { $dbSocket = ""; }
if (!isset($dbUser))   { $dbUser = ""; }
if (!isset($dbPass))   { $dbPass = ""; }
if (!isset($dbName))   { $dbName = ""; }

//DB 接続文字セット（テーブルも utf8mb4 に揃える。utf8(utf8mb3) 混在は照合順序エラーの元）
define("_DB_CHARACTER_SET_", "utf8mb4");

$DefaultDB = $dbName;

  //ﾃﾞｰﾀ保存ﾊﾟｽ
$DefaultDataDirPath = "./swdata";
  //ﾃﾞｰﾀﾃﾝﾌﾟﾚｰﾄﾊﾟｽ
$DefaultTempDirPath = "./TEMP";
//Max Culumn name length (MySqlのcolumn名の最大長は64文字)
$maxColNameLength = 32;

//server root path
define("_ROOT_URL_","https://scenariowritercafe.com/");
//define("_ROOT_URL_","http://scenariowritercafe/");
//日付SelectBox 開始年と終了年
define("_STNEN_","5");//5年前
define("_EDNEN_","2");//2年後

//管理者
define("_ADMIN_","1");

//LOGIN ID継承 MAX秒
define("_sw_access_max_","36000");


// ------------------------------------------------------------------------------
?>
