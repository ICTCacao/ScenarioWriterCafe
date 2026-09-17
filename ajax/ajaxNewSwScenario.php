<?php
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//     SW_SCENARIO I/O ｼｽﾃﾑ
//
//     ajaxNewSwScenario.php
// -----------------------------------------------------------
// ------------------------------------------------------------------------------
	//定数読み込み
	include_once("../sw_config/swConstant.php");
	//DB接続ｸﾗｽの初期化
	include_once("../include/ConnectMySQL.php");
// ------------------------------------------------------------------------------
	//共通関数をｲﾝｸﾙｰﾄﾞ
	include_once("../include/swFunc.php");
	//ﾌｫｰﾑのﾃﾞｰﾀを読み込む
	fncGetPostItems($mySqlConnObj);

	//MainProcedure
	fncMainProc($mySqlConnObj);

	exit();

// ------------------------------------------------------------------------------
//      POSTされた要素を取得
//          fncGetPostItems()
// ------------------------------------------------------------------------------
function fncGetPostItems($mySqlConnObj){
	//共通global変数
	global	$SubMode;
	//ﾌｫｰﾑ name要素をglobal変数にする
	global	$fdtScenarioId;
	global	$fdtUserId;
	global	$fdtScenarioTitle;
	global	$fdtScenarioSubtitle;
	global	$fdtScenarioWriterName;
	global	$fdtScenarioMemo;
	global	$fdtScenarioDate;
	global	$fdtScenarioCategory;

	global	$fdtUserLoginId,$fdtUserLoginDate;
	//POSTされたログイン要素を取得
	$fdtUserLoginId = swFunc_GetPostData('fdtUserLoginId');          //USERログインID
	$fdtUserLoginDate = swFunc_GetPostData('fdtUserLoginDate');      //USERログイン日時

	//ﾛｸﾞｲﾝ情報からﾕｰｻﾞ情報を取得
	//ﾃﾞｰﾀ管理ｸﾗｽ ﾛｸﾞｲﾝ情報
	include_once("../class/clsSwUserLoginInfo.php");
	$clsSwUserLoginInfo = new clsSwUserLoginInfo();
	//ﾃﾞｰﾀ管理ｸﾗｽの初期化
	$clsSwUserLoginInfo->clsSwUserLoginInfoInit($mySqlConnObj,$fdtUserLoginId);
	//ﾌﾟﾛﾊﾟﾃｨGet
	$fdtUserId = $clsSwUserLoginInfo->clsSwUserLoginInfoGetUserId();                    //USER_ID


	//処理ﾓｰﾄが空白ならreturnするﾞ
	if(!isset($_POST['SubMode'])){return;}
	//処理ﾓｰﾄﾞ
	$SubMode = swFunc_GetPostData('SubMode');
	if($SubMode == ''){return;}
	//POSTされた要素を取得
	//$fdtScenarioId = swFunc_GetPostData('fdtScenarioId');            //シナリオID
	//$fdtUserId = swFunc_GetPostData('fdtUserId');                    //USER_ID
	$fdtScenarioTitle = swFunc_GetPostData('fdtScenarioTitle');      //タイトル
	$fdtScenarioSubtitle = swFunc_GetPostData('fdtScenarioSubtitle');//サブタイトル
	$fdtScenarioWriterName = swFunc_GetPostData('fdtScenarioWriterName');//作者名
	$fdtScenarioMemo = swFunc_GetPostData('fdtScenarioMemo');        //メモ
	$fdtScenarioDate = swFunc_GetPostData('fdtScenarioDate');        //執筆日
	$fdtScenarioCategory = swFunc_GetPostData('fdtScenarioCategory');//分類

	global	$fdtBeforeAddMakuName,$fdtMakuSuu,$fdtAfterAddMakuName;
	global	$fdtBeforeAddBaName,$fdtBaSuu,$fdtAfterAddBaName;
	global	$fdtAfterAddCaraName,$fdtCaraSuu;
	
	//場面設定データ
	$fdtBeforeAddMakuName = swFunc_GetPostData('fdtBeforeAddMakuName'); //幕名前
	$fdtMakuSuu = swFunc_GetPostData('fdtMakuSuu'); 											//幕数
	$fdtAfterAddMakuName = swFunc_GetPostData('fdtAfterAddMakuName');		//幕名前後

	$fdtBeforeAddBaName = swFunc_GetPostData('fdtBeforeAddBaName');	//場名前前
	$fdtBaSuu = swFunc_GetPostData('fdtBaSuu');												//場数
	$fdtAfterAddBaName = swFunc_GetPostData('fdtAfterAddBaName');			//場名前後
	
	//登場人物
	$fdtAfterAddCaraName = swFunc_GetPostData('fdtAfterAddCaraName');			//登場人物
	$fdtCaraSuu = swFunc_GetPostData('fdtCaraSuu');			//登場人物数
	
}//end function

// ------------------------------------------------------------------------------
//      MAIN PROCEDURE
//          fncMainProc($mySqlConnObj)
// ------------------------------------------------------------------------------
function fncMainProc($mySqlConnObj){
	global	$SubMode;
	//global 変数
	global	$fdtScenarioId;
	global	$fdtUserId;
	global	$fdtScenarioTitle;
	global	$fdtScenarioSubtitle;
	global	$fdtScenarioWriterName;
	global	$fdtScenarioMemo;
	global	$fdtScenarioDate;
	global	$fdtScenarioCategory;

	// 出力をクリア
	$resultHtml = '';

	//SubModeで処理を制御
	if($SubMode == 'InsertNewScenario'){
		$resultHtml = fncInsertNewScenario($mySqlConnObj);
	}

	// 出力charsetをUTF-8に指定
	mb_http_output ( 'UTF-8' );
	// 出力
	echo($resultHtml);
}//end function

//--------------------------------------------------------------------------------
// fncInsertNewScenario
//--------------------------------------------------------------------------------
function fncInsertNewScenario($mySqlConnObj){
	//global 変数
	global	$fdtScenarioId;
	global	$fdtUserId;
	global	$fdtScenarioTitle;
	global	$fdtScenarioSubtitle;
	global	$fdtScenarioWriterName;
	global	$fdtScenarioMemo;
	global	$fdtScenarioDate;
	global	$fdtScenarioCategory;
	
	//ﾃﾞｰﾀ管理ｸﾗｽ
	include_once("../class/clsSwScenario.php");
	$clsSwScenario = new clsSwScenario();
	//ﾃﾞｰﾀ管理ｸﾗｽでInsert
	fncSwScenarioDBInsert($mySqlConnObj,$clsSwScenario);
	return;
}

// ------------------------------------------------------------------------------
//      ﾌﾟﾛﾊﾟﾃｨReset
//          fncSwScenarioResetProperty($clsSwScenario)
// ------------------------------------------------------------------------------
function fncSwScenarioResetProperty($clsSwScenario){
	global	$fdtScenarioId;
	global	$fdtUserId;
	global	$fdtScenarioTitle;
	global	$fdtScenarioSubtitle;
	global	$fdtScenarioWriterName;
	global	$fdtScenarioMemo;
	global	$fdtScenarioDate;
	global	$fdtScenarioCategory;

	//ﾌﾟﾛﾊﾟﾃｨReset
	$fdtScenarioId = "";                      //シナリオID
	$fdtUserId = "";                          //USER_ID
	$fdtScenarioTitle = "";                   //タイトル
	$fdtScenarioSubtitle = "";                //サブタイトル
	$fdtScenarioWriterName = "";              //作者名
	$fdtScenarioMemo = "";                    //メモ
	$fdtScenarioDate = "";                    //執筆日
	$fdtScenarioCategory = "";				//分類
}//end function

// ------------------------------------------------------------------------------
//      ﾌﾟﾛﾊﾟﾃｨGet
//          fncSwScenarioGetProperty($clsSwScenario)
// ------------------------------------------------------------------------------
function fncSwScenarioGetProperty($clsSwScenario){
	global	$fdtScenarioId;
	global	$fdtUserId;
	global	$fdtScenarioTitle;
	global	$fdtScenarioSubtitle;
	global	$fdtScenarioWriterName;
	global	$fdtScenarioMemo;
	global	$fdtScenarioDate;
	global	$fdtScenarioCategory;

	//ﾌﾟﾛﾊﾟﾃｨGet
	$fdtScenarioId = $clsSwScenario->clsSwScenarioGetScenarioId();            //シナリオID
	$fdtUserId = $clsSwScenario->clsSwScenarioGetUserId();                    //USER_ID
	$fdtScenarioTitle = $clsSwScenario->clsSwScenarioGetScenarioTitle();      //タイトル
	$fdtScenarioSubtitle = $clsSwScenario->clsSwScenarioGetScenarioSubtitle();//サブタイトル
	$fdtScenarioWriterName = $clsSwScenario->clsSwScenarioGetScenarioWriterName();//作者名

	//メモは<br>を\nに変換する
	$fdtScenarioMemo = $clsSwScenario->clsSwScenarioGetScenarioMemo();        //メモ
	$fdtScenarioMemo = str_replace("<br>","\n",$fdtScenarioMemo);

	$fdtScenarioDate = $clsSwScenario->clsSwScenarioGetScenarioDate();        //執筆日
	
	$fdtScenarioCategory = $clsSwScenario->clsSwScenarioGetScenarioCategory();//分類
}//end function

// ------------------------------------------------------------------------------
//      ﾌﾟﾛﾊﾟﾃｨSet
//          fncSwScenarioSetProperty($clsSwScenario)
// ------------------------------------------------------------------------------
function fncSwScenarioSetProperty($clsSwScenario){
	global	$fdtScenarioId;
	global	$fdtUserId;
	global	$fdtScenarioTitle;
	global	$fdtScenarioSubtitle;
	global	$fdtScenarioWriterName;
	global	$fdtScenarioMemo;
	global	$fdtScenarioDate;
	global	$fdtScenarioCategory;

	//ﾌﾟﾛﾊﾟﾃｨSet

	//シナリオIDはｶﾝﾏを取り除いてからSetする
	$fdtScenarioId = str_replace(",","",(string)$fdtScenarioId);   //PHP8.1: null を渡すと Deprecated
	$clsSwScenario->clsSwScenarioSetScenarioId($fdtScenarioId);            //シナリオID


	//USER_IDはｶﾝﾏを取り除いてからSetする
	$fdtUserId = str_replace(",","",$fdtUserId);
	$clsSwScenario->clsSwScenarioSetUserId($fdtUserId);                    //USER_ID

	$clsSwScenario->clsSwScenarioSetScenarioTitle($fdtScenarioTitle);      //タイトル
	$clsSwScenario->clsSwScenarioSetScenarioSubtitle($fdtScenarioSubtitle);//サブタイトル
	$clsSwScenario->clsSwScenarioSetScenarioWriterName($fdtScenarioWriterName);//作者名

	//メモは改行を<br>にしてからSetする
	$fdtScenarioMemo = str_replace("\r\n","<br>",$fdtScenarioMemo);
	$fdtScenarioMemo = str_replace("\r","<br>",$fdtScenarioMemo);
	$fdtScenarioMemo = str_replace("\n","<br>",$fdtScenarioMemo);
	$clsSwScenario->clsSwScenarioSetScenarioMemo($fdtScenarioMemo);        //メモ

	$clsSwScenario->clsSwScenarioSetScenarioDate($fdtScenarioDate);        //執筆日
	$clsSwScenario->clsSwScenarioSetScenarioCategory($fdtScenarioCategory);        //分類
}//end function

// ------------------------------------------------------------------------------
//      DB INSERT
//          fncSwScenarioDBInsert($mySqlConnObj,$clsSwScenario)
// ------------------------------------------------------------------------------
function fncSwScenarioDBInsert($mySqlConnObj,$clsSwScenario){
	global	$fdtScenarioId;
	global	$fdtBeforeAddMakuName,$fdtMakuSuu,$fdtAfterAddMakuName;
	global	$fdtBeforeAddBaName,$fdtBaSuu,$fdtAfterAddBaName;
	global	$fdtAfterAddCaraName,$fdtCaraSuu;

	//ﾌﾟﾛﾊﾟﾃｨｾｯﾄ
	fncSwScenarioSetProperty($clsSwScenario);
	//ﾃﾞｰﾀ管理ｸﾗｽ DbInsert
	$fdtScenarioId = $clsSwScenario->clsSwScenarioDbInsert($mySqlConnObj);

	//場面追加
	//ﾃﾞｰﾀ管理ｸﾗｽ
	include_once("../class/clsSwScene.php");
	$clsSwScene = new clsSwScene();
	
	$orderNo = 0;
	for( $maku = 1 ; $maku <= $fdtMakuSuu ;$maku++ ){
		for( $ba = 1 ; $ba <= $fdtBaSuu ;$ba++ ){
			//プロパティSet
			$clsSwScene->clsSwSceneSetScenarioId($fdtScenarioId);            //SCENARIO_ID
			$orderNo = $orderNo + 100;
			$fdtSceneOrderNo = $orderNo;//場面順番
			$clsSwScene->clsSwSceneSetSceneOrderNo($fdtSceneOrderNo);        //場面順番
			$fdtSceneValidCd = '0';//有効
			$clsSwScene->clsSwSceneSetSceneValidCd($fdtSceneValidCd);        //有効
			//場面名称組み立て
			$fdtSceneName = $fdtBeforeAddMakuName.$maku.$fdtAfterAddMakuName.$fdtBeforeAddBaName.$ba.$fdtAfterAddBaName;
			$clsSwScene->clsSwSceneSetSceneName($fdtSceneName);              //場面名称

			//ﾃﾞｰﾀ管理ｸﾗｽ DbInsert
			$fdtSceneId = $clsSwScene->clsSwSceneDbInsert($mySqlConnObj);
		}
	}

	//登場人物追加
	//ﾃﾞｰﾀ管理ｸﾗｽ
	include_once("../class/clsSwCharacter.php");
	$clsSwCharacter = new clsSwCharacter();
	$orderNo = 0;
	for( $cara = 1 ; $cara <= $fdtCaraSuu ;$cara++ ){
		//プロパティSet
		$clsSwCharacter->clsSwCharacterSetScenarioId($fdtScenarioId);            //SCENARIO_ID
		$orderNo = $orderNo + 100;
		$fdtCharacterOrderNo = $orderNo;
		$clsSwCharacter->clsSwCharacterSetCharacterOrderNo($fdtCharacterOrderNo);//並び順
		$fdtCharacterName =$fdtAfterAddCaraName.$cara;
		$clsSwCharacter->clsSwCharacterSetCharacterName($fdtCharacterName);      //登場人物名
		//ﾃﾞｰﾀ管理ｸﾗｽ DbInsert
		$fdtCharacterId = $clsSwCharacter->clsSwCharacterDbInsert($mySqlConnObj);
	}

}//end function

