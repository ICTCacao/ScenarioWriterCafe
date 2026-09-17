<?php
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//     SW_SCENARIO I/O ｼｽﾃﾑ
//
//     ajaxSwScenario.php
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
	fncGetPostItems();

	//MainProcedure
	fncMainProc($mySqlConnObj);

	exit();

// ------------------------------------------------------------------------------
//      POSTされた要素を取得
//          fncGetPostItems()
// ------------------------------------------------------------------------------
function fncGetPostItems(){
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

	global	$fdtUserLoginId,$fdtUserLoginDate;
	//POSTされたログイン要素を取得
	$fdtUserLoginId = swFunc_GetPostData('fdtUserLoginId');          //USERログインID
	$fdtUserLoginDate = swFunc_GetPostData('fdtUserLoginDate');      //USERログイン日時

	//処理ﾓｰﾄが空白ならreturnするﾞ
	if(!isset($_POST['SubMode'])){return;}
	//処理ﾓｰﾄﾞ
	$SubMode = swFunc_GetPostData('SubMode');
	if($SubMode == ''){return;}
	//POSTされた要素を取得
	$fdtScenarioId = swFunc_GetPostData('fdtScenarioId');            //シナリオID
	$fdtUserId = swFunc_GetPostData('fdtUserId');                    //USER_ID
	$fdtScenarioTitle = swFunc_GetPostData('fdtScenarioTitle');      //タイトル
	$fdtScenarioSubtitle = swFunc_GetPostData('fdtScenarioSubtitle');//サブタイトル
	$fdtScenarioWriterName = swFunc_GetPostData('fdtScenarioWriterName');//作者名
	$fdtScenarioMemo = swFunc_GetPostData('fdtScenarioMemo');        //メモ
	$fdtScenarioDate = swFunc_GetPostData('fdtScenarioDate');        //執筆日
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

	// 出力をクリア
	$resultHtml = '';

	//SubModeで処理を制御
	if($SubMode == 'SwScenarioList'){
		$resultHtml = fncMakeSwScenarioList($mySqlConnObj);
	}
	// 出力charsetをUTF-8に指定
	mb_http_output ( 'UTF-8' );
	// 出力
	echo($resultHtml);
}//end function


//--------------------------------------------------------------------------------
// SW_SCENARIO ALL LIST
//--------------------------------------------------------------------------------
function fncMakeSwScenarioList($mySqlConnObj){
	global	$fdtUserLoginId,$fdtUserLoginDate;

	//ﾛｸﾞｲﾝ情報からﾕｰｻﾞ情報を取得
	//ﾃﾞｰﾀ管理ｸﾗｽ ﾛｸﾞｲﾝ情報
	include_once("../class/clsSwUserLoginInfo.php");
	$clsSwUserLoginInfo = new clsSwUserLoginInfo();
	//ﾃﾞｰﾀ管理ｸﾗｽの初期化
	$clsSwUserLoginInfo->clsSwUserLoginInfoInit($mySqlConnObj,$fdtUserLoginId);
	//ﾌﾟﾛﾊﾟﾃｨGet
	$fdtUserId = $clsSwUserLoginInfo->clsSwUserLoginInfoGetUserId();                    //USER_ID
	
	//DB から ﾃﾞｰﾀを取得しﾌﾟﾛﾊﾟﾃｨにｾｯﾄする
	$strSQL = <<<END_OF_SQL
		SELECT * FROM SW_SCENARIO
			WHERE USER_ID = '$fdtUserId'
					ORDER BY SCENARIO_ID DESC;
END_OF_SQL;
	//SQLを実行
	$myResult = $mySqlConnObj->query($strSQL);
	//件数取得
	$myRowCnt = $myResult->rowCount();
	if($myRowCnt == 0 ){
		$retHtml = <<<END_OF_HTML
		
		<h5>
		保存されたシナリオはありません。<br>
		新規にシナリオを作成する場合は、メニューから新規シナリオをクリックしてください。
		</h5>
		</p>
		
END_OF_HTML;
	}else{
		$retHtml = '';
		while($myRow = $myResult->fetch(PDO::FETCH_ASSOC)){
			$valScenarioTitle = $myRow['SCENARIO_TITLE'];
			$valScenarioSubTitle = $myRow['SCENARIO_SUBTITLE'];
			$valScenarioDate = $myRow['SCENARIO_DATE'];
			
			$valScenarioId = $myRow['SCENARIO_ID'];
			//ﾘｽﾄ
			$retHtml .= <<<END_OF_HTML
			
				<button type="button" class="SelectScenarioButton"
					onclick="fncSelectSwScenario(frmSwScenario,'$valScenarioId');">
					<p>$valScenarioTitle</p>
					<p style="font-size: 10px;">$valScenarioSubTitle</p>
				</button>
END_OF_HTML;
		}//end while
	}//end if
	
	//結果セットを開放
	$myResult->closeCursor();   //PHP8: mysqli の free() は PDO に無い
	//HTMLを返す
	return $retHtml;
}
