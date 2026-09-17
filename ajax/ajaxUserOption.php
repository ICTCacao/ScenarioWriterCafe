<?php
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//     SW_USER_OPTION I/O ｼｽﾃﾑ
//
//     ajaxUserOption.php
// -----------------------------------------------------------
// ------------------------------------------------------------------------------
	//定数読み込み
	include_once("../sw_config/swConstant.php");
	//DB接続ｸﾗｽの初期化
	include_once("../include/ConnectMySQL.php");
// ------------------------------------------------------------------------------
	//共通関数をｲﾝｸﾙｰﾄﾞ
	include_once("../include/swFunc.php");

	//ﾃﾞｰﾀ管理ｸﾗｽ
	include_once("../class/clsSwUserOption.php");
	$clsSwUserOption = new clsSwUserOption();

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
	global	$fdtUserLoginId;

	//共通global変数
	global	$SubMode,$SubmitMode;

	//ﾌｫｰﾑ name要素をglobal変数にする
	global	$fdtUserOptionId;
	global	$fdtUserId;
	global	$fdtUserOptionStyleId;
	global	$fdtUserOptionStyleOrderNo;
	global	$fdtUserOptionStyleName;
	global	$fdtUserOptionStyleFontSize;
	global	$fdtUserOptionStyleColor;
	global	$fdtUserOptionStyleIndent;
	global	$fdtUserOptionStyleStr;
	global	$fdtUserOptionStyleWord;
	//編集中のID
	global	$SelectUserOptionId;
	global	$tgtId;
	
	//USER SETTING
	global	$fdtCharacterLength,$fdtBodyLength,$fdtUseKagikakko;
	
	//POSTされた要素を取得
	$fdtUserLoginId = swFunc_GetPostData('fdtUserLoginId');          //USERログインID

	//処理ﾓｰﾄが空白ならreturnするﾞ
	if(!isset($_POST['SubMode'])){return;}
	//処理ﾓｰﾄﾞ
	$SubMode = swFunc_GetPostData('SubMode');
	if($SubMode == ''){return;}
	$SubmitMode = swFunc_GetPostData('SubmitMode');

	//POSTされた要素を取得
	$fdtUserOptionId = swFunc_GetPostData('fdtUserOptionId');                //USER_OPTION_ID
	$fdtUserId = swFunc_GetPostData('fdtUserId');                    //USER_ID
	$fdtUserOptionStyleId = swFunc_GetPostData('fdtUserOptionStyleId');//スタイルID
	$fdtUserOptionStyleOrderNo = swFunc_GetPostData('fdtUserOptionStyleOrderNo');//並び順
	$fdtUserOptionStyleName = swFunc_GetPostData('fdtUserOptionStyleName');//スタイル名
	$fdtUserOptionStyleFontSize = swFunc_GetPostData('fdtUserOptionStyleFontSize');//フォントサイズ
	$fdtUserOptionStyleColor = swFunc_GetPostData('fdtUserOptionStyleColor');//文字色
	$fdtUserOptionStyleIndent = swFunc_GetPostData('fdtUserOptionStyleIndent');//字下げ数
	$fdtUserOptionStyleStr = swFunc_GetPostData('fdtUserOptionStyleStr');//省略文字
	$fdtUserOptionStyleWord = swFunc_GetPostData('fdtUserOptionStyleWord');//台詞

	//編集中のID
	$SelectUserOptionId = swFunc_GetPostData('SelectUserOptionId');     //編集中のID
	$tgtId = swFunc_GetPostData('tgtId');     //移動対象のシナリオID

	//USER SETTING
	$fdtCharacterLength = swFunc_GetPostData('fdtCharacterLength');     //キャラクタ部文字数
	$fdtBodyLength = swFunc_GetPostData('fdtBodyLength');     					//BODY文字数
	$fdtUseKagikakko = (swFunc_GetPostData('fdtUseKagikakko') == '1') ? 1 : 0;   //台詞を「」で囲む（ﾁｪｯｸﾎﾞｯｸｽ。未送信=0）
	
}//end function

// ------------------------------------------------------------------------------
//      MAIN PROCEDURE
//          fncMainProc($mySqlConnObj)
// ------------------------------------------------------------------------------
function fncMainProc($mySqlConnObj){
	//共通global変数
	global	$SubMode;

	// 出力をクリア
	$resultHtml = '';

	switch($SubMode){
		case 'ReadUserOptionStyleList':
			$resultHtml = fncReadUserOptionStyleList($mySqlConnObj);
			break;
		case 'MoveUserOptionStyleBefore':
			$resultHtml = fncMoveUserOptionStyleBefore($mySqlConnObj);
			break;
		case 'MoveUserOptionStyleAfter':
			$resultHtml = fncMoveUserOptionStyleAfter($mySqlConnObj);
			break;
		case 'NewUserOptionStyleInit':
			$resultHtml = fncNewUserOptionStyleInit($mySqlConnObj);
			break;
		case 'CloseNewUserOptionStyleEdit':
			$resultHtml = fncCloseNewUserOptionStyleEdit($mySqlConnObj);
			break;
		case 'UserOptionStyleEditSubmit':
			$resultHtml = fncUserOptionStyleEditSubmit($mySqlConnObj);
			break;
		case 'SetUserOptionStyleEditForm':
			$resultHtml = fncSetUserOptionStyleEditForm($mySqlConnObj);
			break;
		case 'CloseUserOptionStyleEditForm':
			$resultHtml = fncCloseUserOptionStyleEditForm($mySqlConnObj);
			break;
		case 'UserOptionSettingSave':
			$resultHtml = fncUserOptionSettingSave($mySqlConnObj);
			break;
		default:
			break;
	}

	// 出力charsetをUTF-8に指定
	mb_http_output ( 'UTF-8' );
	// 出力
	echo($resultHtml);
}//end function
//--------------------------------------------------------------------------------
//		fncUserOptionStyleEditSubmit($mySqlConnObj)
//			スタイル更新
//--------------------------------------------------------------------------------
function fncUserOptionSettingSave($mySqlConnObj){
	global	$fdtUserLoginId;
	//USER SETTING
	global	$fdtCharacterLength,$fdtBodyLength,$fdtUseKagikakko;

	//ﾛｸﾞｲﾝ情報からﾕｰｻﾞ情報を取得
	//ﾃﾞｰﾀ管理ｸﾗｽ ﾛｸﾞｲﾝ情報
	include_once("../class/clsSwUserLoginInfo.php");
	$clsSwUserLoginInfo = new clsSwUserLoginInfo();
	//ﾃﾞｰﾀ管理ｸﾗｽの初期化
	$clsSwUserLoginInfo->clsSwUserLoginInfoInit($mySqlConnObj,$fdtUserLoginId);
	//ﾌﾟﾛﾊﾟﾃｨGet
	$fdtUserId = $clsSwUserLoginInfo->clsSwUserLoginInfoGetUserId(); //USER_ID

	//ﾃﾞｰﾀ管理ｸﾗｽ ﾕｰｻﾞ情報
	include_once("../class/clsSwUserOptionSetting.php");
	$clsSwUserOptionSetting = new clsSwUserOptionSetting();
	//ﾃﾞｰﾀ管理ｸﾗｽの初期化
	$myRowCnt = $clsSwUserOptionSetting->clsSwUserOptionSettingInit($mySqlConnObj,$fdtUserId);
	
	//USER_ID
	$clsSwUserOptionSetting->clsSwUserOptionSettingSetUserId($fdtUserId);                    //USER_ID
	//キャラクタ部の文字数はｶﾝﾏを取り除いてからSetする
	$fdtCharacterLength = str_replace(",","",$fdtCharacterLength);
	$clsSwUserOptionSetting->clsSwUserOptionSettingSetCharacterLength($fdtCharacterLength);  //キャラクタ部の文字数
	//シナリオ本文の文字数はｶﾝﾏを取り除いてからSetする
	$fdtBodyLength = str_replace(",","",$fdtBodyLength);
	$clsSwUserOptionSetting->clsSwUserOptionSettingSetBodyLength($fdtBodyLength);            //シナリオ本文の文字数
	$clsSwUserOptionSetting->clsSwUserOptionSettingSetUseKagikakko($fdtUseKagikakko);        //台詞を「」で囲む

	if($myRowCnt > 0 ){
		//ﾃﾞｰﾀ管理ｸﾗｽ DbUpdate
		$clsSwUserOptionSetting->clsSwUserOptionSettingDbUpdate($mySqlConnObj);
	}else{
		//ﾃﾞｰﾀ管理ｸﾗｽ DbInsert
		$clsSwUserOptionSetting->clsSwUserOptionSettingDbInsert($mySqlConnObj);
	}
	return;
}
//--------------------------------------------------------------------------------
//		fncUserOptionStyleEditSubmit($mySqlConnObj)
//			スタイル更新
//--------------------------------------------------------------------------------
function fncUserOptionStyleEditSubmit($mySqlConnObj){
	//共通global変数
	global	$clsSwUserOption;
	
	global	$SubmitMode;
	global	$fdtUserId;
	global	$fdtUserOptionStyleId;

	//SubmitModeで処理を分岐
	switch($SubmitMode){
		case 'INSERT':
			//スタイルIDを設定する
			$fdtUserOptionStyleId = $clsSwUserOption->fncGetNewUserOptionStyleId($mySqlConnObj,$fdtUserId);
			//登録処理
			fncSwUserOptionDBInsert($mySqlConnObj,$clsSwUserOption);
			break;
		case 'UPDATE':
			//更新処理
			fncSwUserOptionDBUpdate($mySqlConnObj,$clsSwUserOption);
			break;
		case 'DELETE':
			//削除処理
			fncSwUserOptionDBDelete($mySqlConnObj,$clsSwUserOption);
			break;
		default:
			break;
	}
	return;
}
//--------------------------------------------------------------------------------
//	fncNewUserOptionStyleInit($mySqlConnObj)
//		新スタイル登録エリア
//--------------------------------------------------------------------------------
function fncNewUserOptionStyleInit($mySqlConnObj){
	global	$clsSwUserOption;
	global	$fdtUserLoginId;
	//ﾌｫｰﾑ name要素をglobal変数にする
	global	$fdtUserOptionId;
	global	$fdtUserId;
	global	$fdtUserOptionStyleId;
	global	$fdtUserOptionStyleOrderNo;
	global	$fdtUserOptionStyleName;
	global	$fdtUserOptionStyleFontSize;
	global	$fdtUserOptionStyleColor;
	global	$fdtUserOptionStyleIndent;
	global	$fdtUserOptionStyleStr;
	global	$fdtUserOptionStyleWord;

	//ﾛｸﾞｲﾝ情報からﾕｰｻﾞ情報を取得
	//ﾃﾞｰﾀ管理ｸﾗｽ ﾛｸﾞｲﾝ情報
	include_once("../class/clsSwUserLoginInfo.php");
	$clsSwUserLoginInfo = new clsSwUserLoginInfo();
	//ﾃﾞｰﾀ管理ｸﾗｽの初期化
	$clsSwUserLoginInfo->clsSwUserLoginInfoInit($mySqlConnObj,$fdtUserLoginId);
	//ﾌﾟﾛﾊﾟﾃｨGet
	$fdtUserId = $clsSwUserLoginInfo->clsSwUserLoginInfoGetUserId(); //USER_ID

	//HTMLを編集
	$retHtml = <<<END_OF_HTML

										<div class="row mb-3">
											<label for="fdtUserOptionStyleOrderNo" class="col-form-label col-sm-2">並び順</label>
											<div class="col-sm-4">
END_OF_HTML;

	//------------------------------------------------------------
	//CSVﾃﾞｰﾀからselect box を作成する
	$ObjName = "fdtUserOptionStyleOrderNo";		//select box の名称.ID
	//ここでfunctionからCSVﾃﾞｰﾀを取得
	$csvArray = swFunc_MakeSelectItemsCsvUserOptionStyleOrderNo($mySqlConnObj,$fdtUserId);	//CSVﾃﾞｰﾀ
	$default = "$fdtUserOptionStyleOrderNo";		//ﾃﾞﾌｫﾙﾄ値
	$onChange = '';					//onChange で起動する javascript or jQuery
	$ViewCode = FALSE;				//ｺｰﾄﾞを表示する場合はTRUE
	//SelectBoxHtml出力
	$UserOptionStyleOrderNoSelectBox = swFunc_MakeSelectBox($ObjName,$csvArray,$default,$onChange,$ViewCode);
//------------------------------------------------------------

	$retHtml .= <<<END_OF_HTML

												$UserOptionStyleOrderNoSelectBox
											</div>
										</div>
END_OF_HTML;

	//編集項目
	$retHtml .= fncMakeEditFormItems($mySqlConnObj);

	$retHtml .= <<<END_OF_HTML
										<legend class="d-flex flex-wrap align-items-center editmenu">
										<ul class="list-inline">
											<li>
												<input type="button" value="CLOSE"
													id="btnDelete"
													onclick="fncNewUserOptionStyleEditClose(frmSwUserOption);"
													class="btn btn-success btn-sm">
											</li>
											<li>
												<input type="button" value="INSERT"
													id="btnInsert"
													onclick="fncUserOptionStyleEditSubmit(frmSwUserOption,'INSERT');"
													class="btn btn-success btn-sm">
											</li>
										</ul>
										</legend>

END_OF_HTML;
	
	return	$retHtml;
}

//--------------------------------------------------------------------------------
//		fncMakeEditFormItems($mySqlConnObj)
//		編集項目
//--------------------------------------------------------------------------------
function fncMakeEditFormItems($mySqlConnObj){
	global	$clsSwUserOption;
	global	$fdtUserLoginId;
	//ﾌｫｰﾑ name要素をglobal変数にする
	global	$fdtUserOptionId;
	global	$fdtUserId;
	global	$fdtUserOptionStyleId;
	global	$fdtUserOptionStyleOrderNo;
	global	$fdtUserOptionStyleName;
	global	$fdtUserOptionStyleFontSize;
	global	$fdtUserOptionStyleColor;
	global	$fdtUserOptionStyleIndent;
	global	$fdtUserOptionStyleStr;
	global	$fdtUserOptionStyleWord;

	//------------------------------------------------------------
	//CSVﾃﾞｰﾀからselect box を作成する
	$ObjName = "fdtUserOptionStyleWord";		//select box の名称.ID
	//ここでfunctionからCSVﾃﾞｰﾀを取得
	$csvArray = swFunc_MakeSelectItemsCsvLineType();	//CSVﾃﾞｰﾀ
	$default = "$fdtUserOptionStyleWord";		//ﾃﾞﾌｫﾙﾄ値
	$onChange = '';					//onChange で起動する javascript or jQuery
	$ViewCode = FALSE;				//ｺｰﾄﾞを表示する場合はTRUE
	//SelectBoxHtml出力
	$UserOptionStyleWordSelectBox = swFunc_MakeSelectBox($ObjName,$csvArray,$default,$onChange,$ViewCode);
//------------------------------------------------------------

	//input type=color は空文字を受け付けない（新規スタイル時）ので既定色にする
	if ($fdtUserOptionStyleColor == "") { $fdtUserOptionStyleColor = "#000000"; }

	$retHtml = <<<END_OF_HTML
	
										<div class="row row-0">
											<input type="hidden" name="fdtUserOptionId" id="fdtUserOptionId" value="$fdtUserOptionId">
											<input type="hidden" name="fdtUserId" id="fdtUserId" value="$fdtUserId">
											<input type="hidden" name="fdtUserOptionStyleId" id="fdtUserOptionStyleId" value="$fdtUserOptionStyleId">
											<input type="hidden" name="fdtUserOptionStyleOrderNo" id="fdtUserOptionStyleOrderNo" value="$fdtUserOptionStyleOrderNo">
											<label for="fdtUserOptionStyleName" class="col-form-label col-sm-2">スタイル名</label>
											<div class="col-sm-4">
												<input type="text" 
													class="form-control form-control-sm"
													id="fdtUserOptionStyleName" name="fdtUserOptionStyleName"
													value="$fdtUserOptionStyleName"
													placeholder="スタイル名">
											</div>
										</div><!-- end of row mb-3 -->
										<div class="row row-0">
											<label for="fdtUserOptionStyleWord" class="col-form-label col-sm-2"></label>
											<div class="col-sm-5">
												$UserOptionStyleWordSelectBox
											</div>
										</div>
										<div class="row row-0">
											<label for="fdtUserOptionStyleFontSize" class="col-form-label col-sm-2">フォントサイズ</label>
											<div class="col-sm-1">
												<input type="text" 
													class="form-control form-control-sm text-end"
													id="fdtUserOptionStyleFontSize" name="fdtUserOptionStyleFontSize"
													value="$fdtUserOptionStyleFontSize"
													placeholder="14">
											</div>
											<label for="fdtUserOptionStyleColor" class="col-form-label col-sm-2">フォント色</label>
											<div class="col-sm-2">
												<input type="color"
													class="form-control form-control-sm form-control-color"
													id="fdtUserOptionStyleColor" name="fdtUserOptionStyleColor"
													value="$fdtUserOptionStyleColor"
													placeholder="#000000">
											</div>
										</div><!-- end of row mb-3 -->
										<div class="row row-0">
											<label for="fdtUserOptionStyleIndent" class="col-form-label col-sm-2">字下げ数</label>
											<div class="col-sm-1">
												<input type="text" 
													class="form-control form-control-sm text-end"
													id="fdtUserOptionStyleIndent" name="fdtUserOptionStyleIndent"
													value="$fdtUserOptionStyleIndent"
													placeholder="3">
											</div>
											<label for="fdtUserOptionStyleStr" class="col-form-label col-sm-2">省略文字</label>
											<div class="col-sm-1">
												<input type="text" 
													class="form-control form-control-sm text-start"
													id="fdtUserOptionStyleStr" name="fdtUserOptionStyleStr"
													value="$fdtUserOptionStyleStr"
													placeholder="">
											</div>
										</div><!-- end of row mb-3 -->
END_OF_HTML;

	return	$retHtml;
}

//--------------------------------------------------------------------------------
//		fncCloseUserOptionStyleEdit($mySqlConnObj)
//		新スタイル登録エリアCLOSE
//--------------------------------------------------------------------------------
function fncCloseNewUserOptionStyleEdit($mySqlConnObj){
	$retHtml = <<<END_OF_HTML
						<h4>USER STYLE設定
						</h4>
END_OF_HTML;
	return	$retHtml;
}

//--------------------------------------------------------------------------------
//	fncSetUserOptionStyleEditForm($mySqlConnObj)
//		スタイル編集エリア
//--------------------------------------------------------------------------------
function fncSetUserOptionStyleEditForm($mySqlConnObj){
	global	$clsSwUserOption;
	global	$SelectUserOptionId;
	
	//ﾌｫｰﾑ name要素をglobal変数にする
	global	$fdtUserOptionId;
	global	$fdtUserId;
	global	$fdtUserOptionStyleId;
	global	$fdtUserOptionStyleOrderNo;
	global	$fdtUserOptionStyleName;
	global	$fdtUserOptionStyleFontSize;
	global	$fdtUserOptionStyleColor;
	global	$fdtUserOptionStyleIndent;
	global	$fdtUserOptionStyleStr;
	global	$fdtUserOptionStyleWord;
	
	//並び順を整理する
	fncAdjustUserOptionStyleOrderNo($mySqlConnObj,$fdtUserId);
	
	//ﾃﾞｰﾀ管理ｸﾗｽの初期化
	$clsSwUserOption->clsSwUserOptionInit($mySqlConnObj,$SelectUserOptionId);
	//ﾌﾟﾛﾊﾟﾃｨGet
	fncSwUserOptionGetProperty($clsSwUserOption);

	$retHtml = <<<END_OF_HTML
	
									<div id="edit_user_option_style" class="col-sm-12">

END_OF_HTML;

	//編集項目
	$retHtml .= fncMakeEditFormItems($mySqlConnObj);

	$retHtml .= <<<END_OF_HTML

										<legend class="d-flex flex-wrap align-items-center editmenu">
										<ul class="list-inline">
											<li>
												<input type="button" value="CLOSE"
													id="btnDelete"
													onclick="fncUserOptionStyleEditClose(frmSwUserOption,'$SelectUserOptionId');"
													class="btn btn-success btn-sm">
											</li>
											<li>
												<input type="button" value="UPDATE"
													id="btnInsert"
													onclick="fncUserOptionStyleEditSubmit(frmSwUserOption,'UPDATE');"
													class="btn btn-warning btn-sm">
											</li>
											<li>
												<input type="button" value="DELETE"
													id="btnInsert"
													onclick="fncUserOptionStyleEditSubmit(frmSwUserOption,'DELETE');"
													class="btn btn-danger btn-sm">
											</li>
										</ul>
										</legend>
								</div>
END_OF_HTML;
	
	//HTMLを返す
	return $retHtml;

}
//--------------------------------------------------------------------------------
//	fncCloseUserOptionStyleEditForm($mySqlConnObj)
//		スタイル編集エリアCLOSE
//--------------------------------------------------------------------------------
function fncCloseUserOptionStyleEditForm($mySqlConnObj){
	global	$clsSwUserOption;
	global	$SelectUserOptionId;
	
	//ﾌｫｰﾑ name要素をglobal変数にする
	global	$fdtUserOptionId;
	global	$fdtUserId;
	global	$fdtUserOptionStyleId;
	global	$fdtUserOptionStyleOrderNo;
	global	$fdtUserOptionStyleName;
	global	$fdtUserOptionStyleFontSize;
	global	$fdtUserOptionStyleColor;
	global	$fdtUserOptionStyleIndent;
	global	$fdtUserOptionStyleStr;
	global	$fdtUserOptionStyleWord;

	//ﾃﾞｰﾀ管理ｸﾗｽの初期化
	$clsSwUserOption->clsSwUserOptionInit($mySqlConnObj,$SelectUserOptionId);
	//ﾌﾟﾛﾊﾟﾃｨGet
	fncSwUserOptionGetProperty($clsSwUserOption);
	
	//ｻﾆﾀｲｽﾞ
	$fdtUserOptionStyleName = swFunc_SanitizeStrings($fdtUserOptionStyleName);
	//style編集
	$Str = '登場人物名';
	$StrLine = 'シナリオライターカフェ、Scenario writer cafe。';
	//配列に格納
	$OptionStyleArray = swFunc_MakeOptionStyleCss($mySqlConnObj,$clsSwUserOption,$fdtUserOptionId,$Str,$StrLine);
	if (isset($OptionStyleArray[0])){$StrCss = $OptionStyleArray[0];}
	if (isset($OptionStyleArray[1])){$Str = $OptionStyleArray[1];}
	if (isset($OptionStyleArray[2])){$StrLineCss = $OptionStyleArray[2];}
	if (isset($OptionStyleArray[3])){$StrLine = $OptionStyleArray[3];}

	$retHtml = <<<END_OF_HTML

							<span class="col-sm-2 text-center">
									<img src="./css/img/up.png" width="20" style="cursor: pointer;" onclick="fncMoveUserOptionStyleBefore(frmSwUserOption,'$fdtUserOptionId');">
									<img src="./css/img/down.png" width="20" style="cursor: pointer;" onclick="fncMoveUserOptionStyleAfter(frmSwUserOption,'$fdtUserOptionId');">
							</span>
							<span class="col-sm-2 text-start" style="cursor: pointer;"
									onclick="fncSelectUserOptionStyle(frmSwUserOption,'$fdtUserOptionId');">
									$fdtUserOptionStyleName
							</span>
							<span class="col-sm-2" $StrCss>
									$Str
							</span>
							<span class="col-sm-6" $StrLineCss>
									$StrLine
							</span>
END_OF_HTML;
	//HTMLを返す
	return $retHtml;

}

//--------------------------------------------------------------------------------
//	fncAdjustUserOptionStyleOrderNo($mySqlConnObj,$fdtUserId)
//		並び順を整理する
//--------------------------------------------------------------------------------
function fncAdjustUserOptionStyleOrderNo($mySqlConnObj,$fdtUserId){
	global	$clsSwUserOption;
	
	$clsSwUserOption->fncAdjustUserOptionStyleOrderNo($mySqlConnObj,$fdtUserId);
	
}

//--------------------------------------------------------------------------------
//	fncMoveUserOptionStyleBefore
//
//			一つ前に移動させる
//				fncMoveUserOptionStyleBefore($mySqlConnObj)
//--------------------------------------------------------------------------------
function fncMoveUserOptionStyleBefore($mySqlConnObj){
	global	$clsSwUserOption;
	global	$tgtId;
	//ﾌｫｰﾑ name要素をglobal変数にする
	global	$fdtUserOptionId;
	global	$fdtUserId;
	global	$fdtUserOptionStyleId;
	global	$fdtUserOptionStyleOrderNo;
	global	$fdtUserOptionStyleName;
	global	$fdtUserOptionStyleFontSize;
	global	$fdtUserOptionStyleColor;
	global	$fdtUserOptionStyleIndent;
	global	$fdtUserOptionStyleStr;
	global	$fdtUserOptionStyleWord;

	//ﾃﾞｰﾀ管理ｸﾗｽの初期化
	$clsSwUserOption->clsSwUserOptionInit($mySqlConnObj,$tgtId);
	//ﾌﾟﾛﾊﾟﾃｨGet
	fncSwUserOptionGetProperty($clsSwUserOption);
	
	//並び順が小さくて最大の2件をSELECT
	$strSQL = <<<END_OF_SQL
	
	SELECT * FROM SW_USER_OPTION
		WHERE USER_ID = :UserId
				AND  USER_OPTION_STYLE_ORDER_NO < :OrderNo
		ORDER BY USER_OPTION_STYLE_ORDER_NO DESC LIMIT 2;
END_OF_SQL;
	$stmt = $mySqlConnObj->prepare($strSQL);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	//パラメータのセット
	$stmt->bindParam(':UserId', $fdtUserId, PDO::PARAM_INT);
	$stmt->bindParam(':OrderNo', $fdtUserOptionStyleOrderNo, PDO::PARAM_INT);
	$stmt->execute();
	//件数取得
	$myRowCnt = $stmt->rowCount();
	
	//件数で処理を分岐
	switch($myRowCnt){
		case '2':
			//最大LINE
			$myRow = $stmt -> fetch(PDO::FETCH_ASSOC);
			$BeforeMax1_OrderNo = $myRow['USER_OPTION_STYLE_ORDER_NO'];
			//2番目LINE
			$myRow = $stmt -> fetch(PDO::FETCH_ASSOC);
			$BeforeMax2_OrderNo = $myRow['USER_OPTION_STYLE_ORDER_NO'];
			break;
		case '1':
			//最大LINE
			$myRow = $stmt -> fetch(PDO::FETCH_ASSOC);
			$BeforeMax1_OrderNo = $myRow['USER_OPTION_STYLE_ORDER_NO'];
			$BeforeMax2_OrderNo = 0;
			break;
		default:
			$BeforeMax1_OrderNo = 100;
			$BeforeMax2_OrderNo = 0;
			break;
	}
	
	//新しい並び順
	$move_num = round(($BeforeMax1_OrderNo - $BeforeMax2_OrderNo) / 2);
	$fdtUserOptionStyleOrderNo = $BeforeMax1_OrderNo - $move_num;
	
	//更新処理
	fncSwUserOptionDBUpdate($mySqlConnObj,$clsSwUserOption);
	return;
}
//--------------------------------------------------------------------------------
//	fncMoveUserOptionStyleAfter
//
//			一つ前に移動させる
//				fncMoveUserOptionStyleAfter($mySqlConnObj)
//--------------------------------------------------------------------------------
function fncMoveUserOptionStyleAfter($mySqlConnObj){
	global	$clsSwUserOption;
	global	$tgtId;
	//ﾌｫｰﾑ name要素をglobal変数にする
	global	$fdtUserOptionId;
	global	$fdtUserId;
	global	$fdtUserOptionStyleId;
	global	$fdtUserOptionStyleOrderNo;
	global	$fdtUserOptionStyleName;
	global	$fdtUserOptionStyleFontSize;
	global	$fdtUserOptionStyleColor;
	global	$fdtUserOptionStyleIndent;
	global	$fdtUserOptionStyleStr;
	global	$fdtUserOptionStyleWord;

	//ﾃﾞｰﾀ管理ｸﾗｽの初期化
	$clsSwUserOption->clsSwUserOptionInit($mySqlConnObj,$tgtId);
	//ﾌﾟﾛﾊﾟﾃｨGet
	fncSwUserOptionGetProperty($clsSwUserOption);
	
	//並び順が小さくて最大の2件をSELECT
	$strSQL = <<<END_OF_SQL
	
	SELECT * FROM SW_USER_OPTION
		WHERE USER_ID = :UserId
				AND  USER_OPTION_STYLE_ORDER_NO > :OrderNo
		ORDER BY USER_OPTION_STYLE_ORDER_NO LIMIT 2;
END_OF_SQL;
	$stmt = $mySqlConnObj->prepare($strSQL);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	//パラメータのセット
	$stmt->bindParam(':UserId', $fdtUserId, PDO::PARAM_INT);
	$stmt->bindParam(':OrderNo', $fdtUserOptionStyleOrderNo, PDO::PARAM_INT);
	$stmt->execute();

	//件数取得
	$myRowCnt = $stmt->rowCount();
	
	//ScenarioTypeで処理を分岐
	switch($myRowCnt){
		case '2':
			//最小LINE
			$myRow = $stmt -> fetch(PDO::FETCH_ASSOC);
			$BeforeMax1_OrderNo = $myRow['USER_OPTION_STYLE_ORDER_NO'];
			//2番目LINE
			$myRow = $stmt -> fetch(PDO::FETCH_ASSOC);
			$BeforeMax2_OrderNo = $myRow['USER_OPTION_STYLE_ORDER_NO'];
			//新しい並び順
			$move_num = round(($BeforeMax2_OrderNo - $BeforeMax1_OrderNo) / 2);
			$fdtUserOptionStyleOrderNo = $BeforeMax1_OrderNo + $move_num;
			break;
		case '1':
			//最小LINE
			$myRow = $stmt -> fetch(PDO::FETCH_ASSOC);
			$BeforeMax1_OrderNo = $myRow['USER_OPTION_STYLE_ORDER_NO'];
			//新しい並び順
			$fdtUserOptionStyleOrderNo = $BeforeMax1ScenarioLinesOrderNo + 100;
			break;
		default:
			return;
			break;
	}
	
	//更新処理
	fncSwUserOptionDBUpdate($mySqlConnObj,$clsSwUserOption);
	return;
}

//--------------------------------------------------------------------------------
// SW_USER_OPTION ALL LIST
//--------------------------------------------------------------------------------
function fncReadUserOptionStyleList($mySqlConnObj){
	global	$clsSwUserOption;
	global	$tgtId;
	//ﾌｫｰﾑ name要素をglobal変数にする
	global	$fdtUserOptionId;
	global	$fdtUserId;
	global	$fdtUserOptionStyleId;
	global	$fdtUserOptionStyleOrderNo;
	global	$fdtUserOptionStyleName;
	global	$fdtUserOptionStyleFontSize;
	global	$fdtUserOptionStyleColor;
	global	$fdtUserOptionStyleIndent;
	global	$fdtUserOptionStyleStr;
	global	$fdtUserOptionStyleWord;
	
	global	$fdtUserLoginId;
	//ﾛｸﾞｲﾝ情報からﾕｰｻﾞ情報を取得
	//ﾃﾞｰﾀ管理ｸﾗｽ ﾛｸﾞｲﾝ情報
	include_once("../class/clsSwUserLoginInfo.php");
	$clsSwUserLoginInfo = new clsSwUserLoginInfo();
	//ﾃﾞｰﾀ管理ｸﾗｽの初期化
	$clsSwUserLoginInfo->clsSwUserLoginInfoInit($mySqlConnObj,$fdtUserLoginId);
	//ﾌﾟﾛﾊﾟﾃｨGet
	$fdtUserId = $clsSwUserLoginInfo->clsSwUserLoginInfoGetUserId(); //USER_ID
	
	//並び順を整理する
	fncAdjustUserOptionStyleOrderNo($mySqlConnObj,$fdtUserId);
	
	//HTMLを編集
	$retHtml = <<<END_OF_HTML
	
		<div  id="UserOption">
			<div class="row mb-3">
				<div class="col-sm-12">
					<!-- 新スタイル設定エリア -->
					<span id="edit_new">
						<h4>USER STYLE設定
						</h4>
					</span>
				</div>
			</div>
		</div>
			
		<div class="scroll_area">
			<div class="col-sm-12 eidt-chara-head">
				<span class="col-sm-2 text-center">
					並び順
				</span>
				<span class="col-sm-2 text-start">
						スタイル名
				</span>
				<span class="col-sm-2 text-start">
						シナリオヘッダ部
				</span>
				<span class="col-sm-6 text-start">
						シナリオボディ部
				</span>
			</div>

END_OF_HTML;
	//DB から ﾃﾞｰﾀを取得する
	$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER_OPTION
			WHERE USER_ID = :UserId
					ORDER BY USER_OPTION_STYLE_ORDER_NO;
END_OF_SQL;
	$stmt = $mySqlConnObj->prepare($strSQL);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	//パラメータのセット
	$stmt->bindParam(':UserId', $fdtUserId, PDO::PARAM_INT);
	$stmt->execute();
	//件数取得
	$myRowCnt = $stmt->rowCount();
	
	
	if($myRowCnt == '0'){
		//登録がないときは、デフォルト登録する
		fncSwUserOptionDBDefaultInsert($mySqlConnObj,$clsSwUserOption,$fdtUserId);

		//DB から ﾃﾞｰﾀを取得する
		$strSQL = <<<END_OF_SQL
	
			SELECT * FROM SW_USER_OPTION
				WHERE USER_ID = :UserId
						ORDER BY USER_OPTION_STYLE_ORDER_NO;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':UserId', $fdtUserId, PDO::PARAM_INT);
		$stmt->execute();
	}
	//リスト表示
	while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$UserOptionId = $myRow['USER_OPTION_ID'];
			$UserId = $myRow['USER_ID'];
			$UserOptionStyleId = $myRow['USER_OPTION_STYLE_ID'];
			$UserOptionStyleOrderNo = $myRow['USER_OPTION_STYLE_ORDER_NO'];
			$UserOptionStyleName = $myRow['USER_OPTION_STYLE_NAME'];

			//ｻﾆﾀｲｽﾞ
			$UserOptionStyleName = swFunc_SanitizeStrings($UserOptionStyleName);
			//style編集
			$Str = '登場人物名';
			$StrLine = 'シナリオライターカフェ、Scenario writer cafe';
			//配列に格納
			$OptionStyleArray = swFunc_MakeOptionStyleCss($mySqlConnObj,$clsSwUserOption,$UserOptionId,$Str,$StrLine);
			if (isset($OptionStyleArray[0])){$StrCss = $OptionStyleArray[0];}
			if (isset($OptionStyleArray[1])){$Str = $OptionStyleArray[1];}
			if (isset($OptionStyleArray[2])){$StrLineCss = $OptionStyleArray[2];}
			if (isset($OptionStyleArray[3])){$StrLine = $OptionStyleArray[3];}
			
			//表に追加
			$retHtml .= <<<END_OF_HTML
			
						<div id="edit_{$UserOptionId}" class="col-sm-12 eidt-chara">
							<span class="col-sm-2 text-center">
									<img src="./css/img/up.png" width="20" style="cursor: pointer;" onclick="fncMoveUserOptionStyleBefore(frmSwUserOption,'$UserOptionId');">
									<img src="./css/img/down.png" width="20" style="cursor: pointer;" onclick="fncMoveUserOptionStyleAfter(frmSwUserOption,'$UserOptionId');">
							</span>
							<span class="col-sm-2 text-start" style="cursor: pointer;"
									onclick="fncSelectUserOptionStyle(frmSwUserOption,'$UserOptionId');">
									$UserOptionStyleName
							</span>
							<span class="col-sm-2 text-start" $StrCss>
									$Str
							</span>
							<span class="col-sm-6 text-start" $StrLineCss>
									$StrLine
							</span>
						</div>
END_OF_HTML;
	}//end while
	
	$retHtml .= <<<END_OF_HTML
		
		</div><!-- scroll_area end -->
		
		<script type="text/javascript">
			$(document).ready(function() {
				$("#UserOption").scroll(function(){
					var st = $("#UserOption").scrollTop();
					$("#listpos").text(st);
				});
			});
		</script>
		
END_OF_HTML;
	
	//HTMLを返す
	return $retHtml;
}

// ------------------------------------------------------------------------------
//      デフォルト登録
//        fncSwUserOptionDBDefaultInsert($mySqlConnObj,$clsSwUserOption,$valUserId)
// ------------------------------------------------------------------------------
function fncSwUserOptionDBDefaultInsert($mySqlConnObj,$clsSwUserOption,$valUserId){
	global	$fdtUserOptionId;
	global	$fdtUserId;
	global	$fdtUserOptionStyleId;
	global	$fdtUserOptionStyleOrderNo;
	global	$fdtUserOptionStyleName;
	global	$fdtUserOptionStyleFontSize;
	global	$fdtUserOptionStyleColor;
	global	$fdtUserOptionStyleIndent;
	global	$fdtUserOptionStyleStr;
	global	$fdtUserOptionStyleWord;

	//USER_ID
	$fdtUserId = $valUserId;

	//デフォルトセリフ
	$fdtUserOptionStyleId = '1';
	$fdtUserOptionStyleOrderNo = '100';
	$fdtUserOptionStyleName = 'セリフ';
	$fdtUserOptionStyleFontSize = '12';
	$fdtUserOptionStyleColor = '#000000';
	$fdtUserOptionStyleIndent = '0';
	$fdtUserOptionStyleStr = '';
	$fdtUserOptionStyleWord = '1';
	//Insert
	$fdtUserOptionId = fncSwUserOptionDBInsert($mySqlConnObj,$clsSwUserOption);

	//デフォルトト書
	$fdtUserOptionStyleId = '2';
	$fdtUserOptionStyleOrderNo = '200';
	$fdtUserOptionStyleName = 'ト書';
	$fdtUserOptionStyleFontSize = '12';
	$fdtUserOptionStyleColor = '#006400';
	$fdtUserOptionStyleIndent = '3';
	$fdtUserOptionStyleStr = '';
	$fdtUserOptionStyleWord = '0';
	//Insert
	$fdtUserOptionId = fncSwUserOptionDBInsert($mySqlConnObj,$clsSwUserOption);

	//デフォルト歌詞
	$fdtUserOptionStyleId = '3';
	$fdtUserOptionStyleOrderNo = '300';
	$fdtUserOptionStyleName = '歌詞';
	$fdtUserOptionStyleFontSize = '12';
	$fdtUserOptionStyleColor = '#ff4500';
	$fdtUserOptionStyleIndent = '4';
	$fdtUserOptionStyleStr = 'Song';
	$fdtUserOptionStyleWord = '0';
	//Insert
	$fdtUserOptionId = fncSwUserOptionDBInsert($mySqlConnObj,$clsSwUserOption);

	//デフォルト ナレーション
	$fdtUserOptionStyleId = '4';
	$fdtUserOptionStyleOrderNo = '400';
	$fdtUserOptionStyleName = 'ナレーション';
	$fdtUserOptionStyleFontSize = '12';
	$fdtUserOptionStyleColor = '#000000';
	$fdtUserOptionStyleIndent = '0';
	$fdtUserOptionStyleStr = 'NA';
	$fdtUserOptionStyleWord = '1';
	//Insert
	$fdtUserOptionId = fncSwUserOptionDBInsert($mySqlConnObj,$clsSwUserOption);

	//デフォルト モノローグ
	$fdtUserOptionStyleId = '5';
	$fdtUserOptionStyleOrderNo = '500';
	$fdtUserOptionStyleName = 'モノローグ';
	$fdtUserOptionStyleFontSize = '12';
	$fdtUserOptionStyleColor = '#000000';
	$fdtUserOptionStyleIndent = '0';
	$fdtUserOptionStyleStr = 'M';
	$fdtUserOptionStyleWord = '1';
	//Insert
	$fdtUserOptionId = fncSwUserOptionDBInsert($mySqlConnObj,$clsSwUserOption);

	//デフォルト テロップ
	$fdtUserOptionStyleId = '6';
	$fdtUserOptionStyleOrderNo = '600';
	$fdtUserOptionStyleName = 'テロップ';
	$fdtUserOptionStyleFontSize = '12';
	$fdtUserOptionStyleColor = '#ff4500';
	$fdtUserOptionStyleIndent = '4';
	$fdtUserOptionStyleStr = 'T';
	$fdtUserOptionStyleWord = '0';
	//Insert
	$fdtUserOptionId = fncSwUserOptionDBInsert($mySqlConnObj,$clsSwUserOption);

	//デフォルト 演技指示
	$fdtUserOptionStyleId = '7';
	$fdtUserOptionStyleOrderNo = '700';
	$fdtUserOptionStyleName = '演技指示';
	$fdtUserOptionStyleFontSize = '12';
	$fdtUserOptionStyleColor = '#8b0000';
	$fdtUserOptionStyleIndent = '4';
	$fdtUserOptionStyleStr = '';
	$fdtUserOptionStyleWord = '0';
	//Insert
	$fdtUserOptionId = fncSwUserOptionDBInsert($mySqlConnObj,$clsSwUserOption);

	//デフォルト 音響指示
	$fdtUserOptionStyleId = '8';
	$fdtUserOptionStyleOrderNo = '800';
	$fdtUserOptionStyleName = '音響指示';
	$fdtUserOptionStyleFontSize = '12';
	$fdtUserOptionStyleColor = '#8b0000';
	$fdtUserOptionStyleIndent = '4';
	$fdtUserOptionStyleStr = 'SE';
	$fdtUserOptionStyleWord = '0';
	//Insert
	$fdtUserOptionId = fncSwUserOptionDBInsert($mySqlConnObj,$clsSwUserOption);

	//デフォルト 照明指示
	$fdtUserOptionStyleId = '9';
	$fdtUserOptionStyleOrderNo = '900';
	$fdtUserOptionStyleName = '照明指示';
	$fdtUserOptionStyleFontSize = '12';
	$fdtUserOptionStyleColor = '#8b0000';
	$fdtUserOptionStyleIndent = '4';
	$fdtUserOptionStyleStr = 'L';
	$fdtUserOptionStyleWord = '0';
	//Insert
	$fdtUserOptionId = fncSwUserOptionDBInsert($mySqlConnObj,$clsSwUserOption);
	
}
// ------------------------------------------------------------------------------
//      ﾌﾟﾛﾊﾟﾃｨReset
//          fncSwUserOptionResetProperty($clsSwUserOption)
// ------------------------------------------------------------------------------
function fncSwUserOptionResetProperty($clsSwUserOption){
	global	$fdtUserOptionId;
	global	$fdtUserId;
	global	$fdtUserOptionStyleId;
	global	$fdtUserOptionStyleOrderNo;
	global	$fdtUserOptionStyleName;
	global	$fdtUserOptionStyleFontSize;
	global	$fdtUserOptionStyleColor;
	global	$fdtUserOptionStyleIndent;
	global	$fdtUserOptionStyleStr;
	global	$fdtUserOptionStyleWord;

	//ﾌﾟﾛﾊﾟﾃｨReset
	$fdtUserOptionId = "";                        //USER_OPTION_ID
	$fdtUserId = "";                          //USER_ID
	$fdtUserOptionStyleId = "";               //スタイルID
	$fdtUserOptionStyleOrderNo = "";          //並び順
	$fdtUserOptionStyleName = "";             //スタイル名
	$fdtUserOptionStyleFontSize = "";         //フォントサイズ
	$fdtUserOptionStyleColor = "";            //文字色
	$fdtUserOptionStyleIndent = "";           //字下げ数
	$fdtUserOptionStyleStr = "";              //省略文字
	$fdtUserOptionStyleWord = "";             //台詞
}//end function

// ------------------------------------------------------------------------------
//      ﾌﾟﾛﾊﾟﾃｨGet
//          fncSwUserOptionGetProperty($clsSwUserOption)
// ------------------------------------------------------------------------------
function fncSwUserOptionGetProperty($clsSwUserOption){
	global	$fdtUserOptionId;
	global	$fdtUserId;
	global	$fdtUserOptionStyleId;
	global	$fdtUserOptionStyleOrderNo;
	global	$fdtUserOptionStyleName;
	global	$fdtUserOptionStyleFontSize;
	global	$fdtUserOptionStyleColor;
	global	$fdtUserOptionStyleIndent;
	global	$fdtUserOptionStyleStr;
	global	$fdtUserOptionStyleWord;

	//ﾌﾟﾛﾊﾟﾃｨGet
	$fdtUserOptionId = $clsSwUserOption->clsSwUserOptionGetUserOptionId();                //USER_OPTION_ID
	$fdtUserId = $clsSwUserOption->clsSwUserOptionGetUserId();                    //USER_ID
	$fdtUserOptionStyleId = $clsSwUserOption->clsSwUserOptionGetUserOptionStyleId();//スタイルID
	$fdtUserOptionStyleOrderNo = $clsSwUserOption->clsSwUserOptionGetUserOptionStyleOrderNo();//並び順
	$fdtUserOptionStyleName = $clsSwUserOption->clsSwUserOptionGetUserOptionStyleName();//スタイル名
	$fdtUserOptionStyleFontSize = $clsSwUserOption->clsSwUserOptionGetUserOptionStyleFontSize();//フォントサイズ
	$fdtUserOptionStyleColor = $clsSwUserOption->clsSwUserOptionGetUserOptionStyleColor();//文字色
	$fdtUserOptionStyleIndent = $clsSwUserOption->clsSwUserOptionGetUserOptionStyleIndent();//字下げ数
	$fdtUserOptionStyleStr = $clsSwUserOption->clsSwUserOptionGetUserOptionStyleStr();//省略文字
	$fdtUserOptionStyleWord = $clsSwUserOption->clsSwUserOptionGetUserOptionStyleWord();//台詞
}//end function

// ------------------------------------------------------------------------------
//      ﾌﾟﾛﾊﾟﾃｨSet
//          fncSwUserOptionSetProperty($clsSwUserOption)
// ------------------------------------------------------------------------------
function fncSwUserOptionSetProperty($clsSwUserOption){
	global	$fdtUserOptionId;
	global	$fdtUserId;
	global	$fdtUserOptionStyleId;
	global	$fdtUserOptionStyleOrderNo;
	global	$fdtUserOptionStyleName;
	global	$fdtUserOptionStyleFontSize;
	global	$fdtUserOptionStyleColor;
	global	$fdtUserOptionStyleIndent;
	global	$fdtUserOptionStyleStr;
	global	$fdtUserOptionStyleWord;

	//ﾌﾟﾛﾊﾟﾃｨSet
	//USER_OPTION_IDはｶﾝﾏを取り除いてからSetする
	$fdtUserOptionId = str_replace(",","",$fdtUserOptionId);
	$clsSwUserOption->clsSwUserOptionSetUserOptionId($fdtUserOptionId);                //USER_OPTION_ID


	//USER_IDはｶﾝﾏを取り除いてからSetする
	$fdtUserId = str_replace(",","",$fdtUserId);
	$clsSwUserOption->clsSwUserOptionSetUserId($fdtUserId);                    //USER_ID


	//スタイルIDはｶﾝﾏを取り除いてからSetする
	$fdtUserOptionStyleId = str_replace(",","",$fdtUserOptionStyleId);
	$clsSwUserOption->clsSwUserOptionSetUserOptionStyleId($fdtUserOptionStyleId);//スタイルID


	//並び順はｶﾝﾏを取り除いてからSetする
	$fdtUserOptionStyleOrderNo = str_replace(",","",$fdtUserOptionStyleOrderNo);
	$clsSwUserOption->clsSwUserOptionSetUserOptionStyleOrderNo($fdtUserOptionStyleOrderNo);//並び順

	$clsSwUserOption->clsSwUserOptionSetUserOptionStyleName($fdtUserOptionStyleName);//スタイル名

	//フォントサイズはｶﾝﾏを取り除いてからSetする
	$fdtUserOptionStyleFontSize = str_replace(",","",$fdtUserOptionStyleFontSize);
	$clsSwUserOption->clsSwUserOptionSetUserOptionStyleFontSize($fdtUserOptionStyleFontSize);//フォントサイズ

	$clsSwUserOption->clsSwUserOptionSetUserOptionStyleColor($fdtUserOptionStyleColor);//文字色

	//字下げ数はｶﾝﾏを取り除いてからSetする
	$fdtUserOptionStyleIndent = str_replace(",","",$fdtUserOptionStyleIndent);
	$clsSwUserOption->clsSwUserOptionSetUserOptionStyleIndent($fdtUserOptionStyleIndent);//字下げ数

	$clsSwUserOption->clsSwUserOptionSetUserOptionStyleStr($fdtUserOptionStyleStr);//省略文字
	$clsSwUserOption->clsSwUserOptionSetUserOptionStyleWord($fdtUserOptionStyleWord);//台詞
}//end function

// ------------------------------------------------------------------------------
//      DB INSERT
//          fncSwUserOptionDBInsert($mySqlConnObj,$clsSwUserOption)
// ------------------------------------------------------------------------------
function fncSwUserOptionDBInsert($mySqlConnObj,$clsSwUserOption){
	global	$fdtUserOptionId;

	//ﾌﾟﾛﾊﾟﾃｨｾｯﾄ
	fncSwUserOptionSetProperty($clsSwUserOption);
	//ﾃﾞｰﾀ管理ｸﾗｽ DbInsert
	$fdtUserOptionId = $clsSwUserOption->clsSwUserOptionDbInsert($mySqlConnObj);

}//end function

// ------------------------------------------------------------------------------
//      DB UPDATE
//          fncSwUserOptionDBUpdate($mySqlConnObj,$clsSwUserOption)
// ------------------------------------------------------------------------------
function fncSwUserOptionDBUpdate($mySqlConnObj,$clsSwUserOption){
	//ﾌﾟﾛﾊﾟﾃｨｾｯﾄ
	fncSwUserOptionSetProperty($clsSwUserOption);
	//ﾃﾞｰﾀ管理ｸﾗｽ DbUpdate
	$clsSwUserOption->clsSwUserOptionDbUpdate($mySqlConnObj);
}//end function

// ------------------------------------------------------------------------------
//      DB DELETE
//          fncSwUserOptionDBDelete($mySqlConnObj,$clsSwUserOption)
// ------------------------------------------------------------------------------
function fncSwUserOptionDBDelete($mySqlConnObj,$clsSwUserOption){
	//ﾌﾟﾛﾊﾟﾃｨｾｯﾄ
	fncSwUserOptionSetProperty($clsSwUserOption);
	//ﾃﾞｰﾀ管理ｸﾗｽ DbDelete
	$clsSwUserOption->clsSwUserOptionDbDelete($mySqlConnObj);
}//end function
// -----------------------------------------------------------
?>