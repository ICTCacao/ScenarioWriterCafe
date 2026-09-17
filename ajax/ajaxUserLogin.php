<?php
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//     LOGIN_USER I/O ｼｽﾃﾑ
//
//     ajaxUserLogin.php
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
    global  $SubMode;
    //ﾌｫｰﾑ name要素をglobal変数にする
    global  $fdtUserId;
    global  $fdtUserMailad;
    global  $fdtUserPasswd;
    global  $fdtUserName;
 
    //処理ﾓｰﾄが空白ならreturnするﾞ
    if(!isset($_POST['SubMode'])){return;}
    //処理ﾓｰﾄﾞ
    $SubMode = swFunc_GetPostData('SubMode');
    if($SubMode == ''){return;}
    //POSTされた要素を取得
    $fdtUserId = swFunc_GetPostData('fdtUserId');                    //ID
    $fdtUserMailad = swFunc_GetPostData('fdtUserMailad');            //メールアドレス
    $fdtUserPasswd = swFunc_GetPostData('fdtUserPasswd');            //パスワード
    $fdtUserName = swFunc_GetPostData('fdtUserName');                //ユーザー名

    //global変数
    global  $fdtUserLoginId;
    global  $fdtUserLoginDate;

	//POSTされた要素ﾛｸﾞｲﾝ情報を取得
	$fdtUserLoginId = swFunc_GetPostData('fdtUserLoginId');              //ﾛｸﾞｲﾝID
	$fdtUserLoginDate = swFunc_GetPostData('fdtUserLoginDate');          //ﾛｸﾞｲﾝ日時

}//end function
 
// ------------------------------------------------------------------------------
//      MAIN PROCEDURE
//          fncMainProc($mySqlConnObj)
// ------------------------------------------------------------------------------
function fncMainProc($mySqlConnObj){
    global  $SubMode;
    //global 変数
    global  $fdtUserId;
    global  $fdtUserMailad;
    global  $fdtUserPasswd;
    global  $fdtUserName;
 
	// 出力をクリア
	$resultHtml = '';

    //SubModeで処理を制御
    if($SubMode == 'LOGIN'){
        $resultHtml = fncCheckLoginUser($mySqlConnObj);
    }
    if($SubMode == 'RESET_PASSWD'){
        $resultHtml = fncResetPassword($mySqlConnObj);
    }
    if($SubMode == 'CHANGE_PASSWD'){
        $resultHtml = fncChangePassword($mySqlConnObj);
    }
 	
    // 出力charsetをUTF-8に指定
    mb_http_output ( 'UTF-8' );
    // 出力
    echo($resultHtml);
}//end function

//--------------------------------------------------------------------------------
// fncChangePassword($mySqlConnObj)
//--------------------------------------------------------------------------------
function fncChangePassword($mySqlConnObj){
    global  $fdtUserId,$fdtUserMailad,$fdtUserPasswd,$fdtUserName;
	global  $fdtUserLoginId,$fdtUserLoginDate;

	//ﾛｸﾞｲﾝ情報からUSER_IDを取得
	//ﾃﾞｰﾀ管理ｸﾗｽ
	include_once("../class/clsSwUserLoginInfo.php");
	$clsSwUserLoginInfo = new clsSwUserLoginInfo();
	//ﾃﾞｰﾀ管理ｸﾗｽの初期化
	$clsSwUserLoginInfo->clsSwUserLoginInfoInit($mySqlConnObj,$fdtUserLoginId);
	//USER_ID取得
	$fdtUserId = $clsSwUserLoginInfo->clsSwUserLoginInfoGetUserId();
	
	//ﾃﾞｰﾀ管理ｸﾗｽ
	include_once("../class/clsSwUser.php");
	$clsSwUser = new clsSwUser();
	//ﾃﾞｰﾀ管理ｸﾗｽの初期化
	$clsSwUser->clsSwUserInit($mySqlConnObj,$fdtUserId);
	//USER_ID
	$fdtUserId = $clsSwUser->clsSwUserGetUserId();
	$fdtUserMailad = $clsSwUser->clsSwUserGetUserMailad();


	$myRetMes = '';
	//新しい登録名
	$fdtNewUserName = $fdtUserName;
	//パスワード生成
	$fdtNewUserPasswd = swFunc_Hash($fdtUserMailad,$fdtUserPasswd);
	
	//UPDATEしてメール送信する
    //ﾃﾞｰﾀ管理ｸﾗｽの初期化
    $clsSwUser->clsSwUserInit($mySqlConnObj,$fdtUserId);
	//ﾌﾟﾛﾊﾟﾃｨGet
	fncSwUserGetProperty($clsSwUser);
	//新しい登録名に変更
	$fdtUserName = $fdtNewUserName;
	//新しいパスワードに変更
	$fdtUserPasswd = $fdtNewUserPasswd;
	//DB UPDATE処理
	fncSwUserDBUpdate($mySqlConnObj,$clsSwUser);
    //ﾃﾞｰﾀ管理ｸﾗｽの初期化
    $clsSwUser->clsSwUserInit($mySqlConnObj,$fdtUserId);
	//ﾌﾟﾛﾊﾟﾃｨGet
	fncSwUserGetProperty($clsSwUser);
	
	//Lodin情報をメールで送信
	mb_language('ja');
	mb_internal_encoding("utf-8");
	
	$from     = 'support@scenariowritercafe.com';
	$reply_to = 'support@scenariowritercafe.com';
	$to       = $fdtUserMailad;

	$header   = "From: $from\n";
	$header  .= "Reply-To: $reply_to\n";
	$header  .= "X-Mailer: myphpMail ". phpversion(). "\n";
	
	$subject  = "ScenarioWriterCafeのパスワードが変更されました";

	//ユーザー向けメッセージ
	$MailMessage = fncMakeUserChangePasswordMessage();


	// メール送信
	$result = mb_send_mail($to, $subject, $MailMessage, $header);
	if($result){
		//成功
		$myRetMes = <<<END_OF_HTML
			
			<br />
			<p class="text-success">パスワードは正常に変更されました。新しいパスワードでログイン出来ます。</p>
			<input type="hidden" name="retResult" id="retResult" value="">
END_OF_HTML;
	}else{
		//失敗
		$myRetMes = <<<END_OF_HTML
		
			<br />
			<p class="text-danger">パスワード変更失敗！</p>
			<input type="hidden" name="retResult" id="retResult" value="send err!">
END_OF_HTML;
	}
	
	return $myRetMes;
}
// ------------------------------------------------------------------------------
//      ユーザー向けメッセージ
//          fncMakeUserChangePasswordMessage()
// ------------------------------------------------------------------------------
function fncMakeUserChangePasswordMessage(){
    global  $fdtUserMailad,$fdtUserName;
	global	$SendPassWd;

	$MailMessage = "{$fdtUserName}様　\r\n";
	$MailMessage .= "ScenarioWriterCafe利用のパスワードを変更しました。\r\n\r\n";
	$MailMessage .= "以下のURLからメールアドレスと新しいパスワードでログインできます。\r\n\r\n";
	$MailMessage .= "　\r\n";
	$MailMessage .= swFunc_BaseUrl() . "swUserLogin.html \r\n";
	$MailMessage .= "　\r\n";
	$MailMessage .= "　\r\n";
	$MailMessage .= "※このメールは，ScenarioWriterCafe利用に入力されたメールアドレスに自動送信していますので";
	$MailMessage .= "このメールへの返信には対応しておりません。 \r\n";
	$MailMessage .= "　\r\n";

	return	$MailMessage;
}

	


//--------------------------------------------------------------------------------
// fncResetPassword($mySqlConnObj)
//--------------------------------------------------------------------------------
function fncResetPassword($mySqlConnObj){
    global  $fdtUserId,$fdtUserMailad,$fdtUserPasswd,$fdtUserName;
	global	$SendPassWd;
	global  $fdtUserLoginId,$fdtUserLoginDate;

	$myRetMes = '';
    //ﾃﾞｰﾀ管理ｸﾗｽ
    include_once("../class/clsSwUser.php");
    $clsSwUser = new clsSwUser();

	//仮のﾊﾟｽﾜｰﾄﾞ文字列設定
	$SendPassWd = swFunc_MakeNewPassword();
	//パスワード生成
	$fdtNewUserPasswd = swFunc_Hash($fdtUserMailad,$SendPassWd);
	
	//新規判定
    //ﾌﾟﾛﾊﾟﾃｨｾｯﾄ
    fncSwUserSetProperty($clsSwUser);
    //メールアドレス登録確認　登録されていればユーザーID(メールアドレス)を返す
    $fdtUserId = $clsSwUser->clsSwUserCheckMailAd($mySqlConnObj);
    //メールアドレスが登録されていなければエラー
    if ( $fdtUserId == '' ){
    	$retMailAd = swFunc_SanitizeStrings($fdtUserMailad);
		$myRetMes = <<<END_OF_HTML

				<div class="text-danger">メールアドレス{$retMailAd}は登録されていません。</div>
				<input type="hidden" name="retResult" id="retResult" value="メールアドレス{$retMailAd}は登録されていません。">
END_OF_HTML;

		return $myRetMes;
	}
	
	
	//メールアドレスが登録されているときは、UPDATEして仮パスワードをメール送信する
    //ﾃﾞｰﾀ管理ｸﾗｽの初期化
    $clsSwUser->clsSwUserInit($mySqlConnObj,$fdtUserId);
	//ﾌﾟﾛﾊﾟﾃｨGet
	fncSwUserGetProperty($clsSwUser);







	//新しいパスワードに変更
	$fdtUserPasswd = $fdtNewUserPasswd;
	//DB UPDATE処理
	fncSwUserDBUpdate($mySqlConnObj,$clsSwUser);
    //ﾃﾞｰﾀ管理ｸﾗｽの初期化
    $clsSwUser->clsSwUserInit($mySqlConnObj,$fdtUserId);
	//ﾌﾟﾛﾊﾟﾃｨGet
	fncSwUserGetProperty($clsSwUser);
	
	//Lodin情報をメールで送信
	mb_language('ja');
	mb_internal_encoding("utf-8");
	
	$from     = 'support@scenariowritercafe.com';
	$reply_to = 'support@scenariowritercafe.com';
	$to       = $fdtUserMailad;

	$header   = "From: $from\n";
	$header  .= "Reply-To: $reply_to\n";
	$header  .= "X-Mailer: myphpMail ". phpversion(). "\n";

	$subject  = "ScenarioWriterCafeのパスワードをリセットしました";
	//ユーザー向けメッセージ
	$MailMessage = fncMakeUserMessage();
	
	// メール送信
	$result = mb_send_mail($to, $subject, $MailMessage, $header);
	if($result){
		//成功
		$myRetMes = <<<END_OF_HTML
			
			<input type="hidden" name="retResult" id="retResult" value="">
			<input type="hidden" name="fdtUserName" id="fdtUserName" value="$fdtUserName">
END_OF_HTML;
	}else{
		//失敗
		$myRetMes = <<<END_OF_HTML
		
			<input type="hidden" name="retResult" id="retResult" value="send err!">
END_OF_HTML;
	}
	
	return $myRetMes;
}

// ------------------------------------------------------------------------------
//      ユーザー向けメッセージ
//          fncMakeUserMessage()
// ------------------------------------------------------------------------------
function fncMakeUserMessage(){
    global  $fdtUserMailad,$fdtUserName;
	global	$SendPassWd;

	$MailMessage = "{$fdtUserName}様　\r\n";
	$MailMessage .= "ScenarioWriterCafe利用のパスワードを変更しました。\r\n\r\n";
	$MailMessage .= "以下のURLからメールアドレスと仮のパスワードでログインできます。\r\n\r\n";
	$MailMessage .= "　\r\n";
	$MailMessage .= swFunc_BaseUrl() . "swUserLogin.html \r\n";
	$MailMessage .= "　\r\n";
	$MailMessage .= "　\r\n";
	$MailMessage .= "　仮のパスワード： {$SendPassWd}\r\n";
	$MailMessage .= "　\r\n";
	$MailMessage .= "※このメールは，ScenarioWriterCafe利用に入力されたメールアドレスに自動送信していますので";
	$MailMessage .= "このメールへの返信には対応しておりません。 \r\n";
	$MailMessage .= "　\r\n";

	return	$MailMessage;
}

//--------------------------------------------------------------------------------
// fncCheckLoginUser($mySqlConnObj)
//--------------------------------------------------------------------------------
function fncCheckLoginUser($mySqlConnObj){
	global  $fdtUserId,$fdtUserMailad,$fdtUserPasswd,$fdtUserName;
	global	$SendPassWd;
	global  $fdtUserLoginId,$fdtUserLoginDate;

	//入力したパスワードを保存
	$input_password = $fdtUserPasswd;
	
	$myRetMes = '';

	//ﾃﾞｰﾀ管理ｸﾗｽ
	include_once("../class/clsSwUser.php");
	$clsSwUser = new clsSwUser();

	//ﾒｰﾙｱﾄﾞﾚｽﾁｪｯｸ
	//ﾌﾟﾛﾊﾟﾃｨｾｯﾄ
	fncSwUserSetProperty($clsSwUser);
	$fdtUserId = $clsSwUser->clsSwUserCheckMailAd($mySqlConnObj);
	
	if ($fdtUserId == FALSE){
		//メールアドレスの登録がないとき
		$myRetMes = <<<END_OF_HTML
		
			<p class="caption">メールアドレス<font color="red">{$fdtUserMailad}</font>は、登録されていません。<br />メールアドレス登録画面からご利用ください。</p>
			<input type="hidden" name="retResult" id="retResult" value="登録されていません。">
END_OF_HTML;

		return $myRetMes;
	}else{
		//メールアドレスの登録あり
		//入力したパスワードとメールアドレスからハッシュを生成
		$chkPassWd = swFunc_Hash($fdtUserMailad,$input_password);

		//ﾊﾟｽﾜｰﾄﾞのﾁｪｯｸ
	  //USER情報ﾃﾞｰﾀ管理ｸﾗｽの初期化
	  $clsSwUser->clsSwUserInit($mySqlConnObj,$fdtUserId);
		//ﾌﾟﾛﾊﾟﾃｨGet
		fncSwUserGetProperty($clsSwUser);
	    
		//ﾊﾟｽﾜｰﾄﾞﾁｪｯｸ
		if ($chkPassWd == $fdtUserPasswd){
			//ﾊﾟｽﾜｰﾄﾞ一致のときは、ﾛｸﾞｲﾝ情報を格納する
			//ﾃﾞｰﾀ管理ｸﾗｽ
			include_once("../class/clsSwUserLoginInfo.php");
			$clsSwUserLoginInfo = new clsSwUserLoginInfo();
			//ﾛｸﾞｲﾝIDを生成
			$fdtUserLoginId = uniqid("",true);
			//USER_IDでDELETE
			fncSwUserLoginInfoDBDelete($mySqlConnObj,$clsSwUserLoginInfo);
			//INSERT
			fncSwUserLoginInfoDBInsert($mySqlConnObj,$clsSwUserLoginInfo);
			//ﾃﾞｰﾀ管理ｸﾗｽの初期化
			$clsSwUserLoginInfo->clsSwUserLoginInfoInit($mySqlConnObj,$fdtUserLoginId);
			//ﾌﾟﾛﾊﾟﾃｨの取得
			fncSwUserLoginInfoGetProperty($clsSwUserLoginInfo);
			
			// セッション開始
			session_name('scenario-writer-cafe');
			session_start();

			$_SESSION['swLoginId'] = $fdtUserLoginId;
			$_SESSION['swLoginDate'] = $fdtUserLoginDate;
			
			$myRetMes = <<<END_OF_HTML
				
				<input type="hidden" name="retResult" id="retResult" value="">
				<input type="hidden" name="fdtUserLoginId" id="fdtUserLoginId" value="$fdtUserLoginId">
				<input type="hidden" name="fdtUserLoginDate" id="fdtUserLoginDate" value="$fdtUserLoginDate">
END_OF_HTML;
	    }else{
			//ﾊﾟｽﾜｰﾄﾞ不一致
			$myRetMes = <<<END_OF_HTML
		
			<p class="caption"><font color="red">パスワードが違います。</font>
			<br />パスワードをご確認ください。</p>
			<input type="hidden" name="retResult" id="retResult" value="パスワードが違います。">
END_OF_HTML;
	    }
	}

	return $myRetMes;

}


// ------------------------------------------------------------------------------
//      ﾌﾟﾛﾊﾟﾃｨReset
//          fncSwUserResetProperty($clsSwUser)
// ------------------------------------------------------------------------------
function fncSwUserResetProperty($clsSwUser){
    global  $fdtUserId;
    global  $fdtUserMailad;
    global  $fdtUserPasswd;
    global  $fdtUserName;
 
    //ﾌﾟﾛﾊﾟﾃｨReset
    $fdtUserId = "";
    $fdtUserMailad = "";
    $fdtUserPasswd = "";
    $fdtUserName = "";
}//end function
 
// ------------------------------------------------------------------------------
//      ﾌﾟﾛﾊﾟﾃｨGet
//          fncSwUserGetProperty($clsSwUser)
// ------------------------------------------------------------------------------
function fncSwUserGetProperty($clsSwUser){
    global  $fdtUserId;
    global  $fdtUserMailad;
    global  $fdtUserPasswd;
    global  $fdtUserName;
 
    //ﾌﾟﾛﾊﾟﾃｨGet
    $fdtUserId = $clsSwUser->clsSwUserGetUserId();
    $fdtUserMailad = $clsSwUser->clsSwUserGetUserMailad();
    $fdtUserPasswd = $clsSwUser->clsSwUserGetUserPasswd();
    $fdtUserName = $clsSwUser->clsSwUserGetUserName();
}//end function
 
// ------------------------------------------------------------------------------
//      ﾌﾟﾛﾊﾟﾃｨSet
//          fncSwUserSetProperty($clsSwUser)
// ------------------------------------------------------------------------------
function fncSwUserSetProperty($clsSwUser){
    global  $fdtUserId;
    global  $fdtUserMailad;
    global  $fdtUserPasswd;
    global  $fdtUserName;
 
    //ﾌﾟﾛﾊﾟﾃｨSet
    $clsSwUser->clsSwUserSetUserId($fdtUserId);
    $clsSwUser->clsSwUserSetUserMailad($fdtUserMailad);
    $clsSwUser->clsSwUserSetUserPasswd($fdtUserPasswd);
    $clsSwUser->clsSwUserSetUserName($fdtUserName);


}//end function
 
// ------------------------------------------------------------------------------
//      DB INSERT
//          fncSwUserDBInsert($mySqlConnObj,$clsSwUser)
// ------------------------------------------------------------------------------
function fncSwUserDBInsert($mySqlConnObj,$clsSwUser){
    global  $fdtUserId;
 
    //ﾌﾟﾛﾊﾟﾃｨｾｯﾄ
    fncSwUserSetProperty($clsSwUser);
    //ﾃﾞｰﾀ管理ｸﾗｽ DbInsert
    $fdtUserId = $clsSwUser->clsSwUserDbInsert($mySqlConnObj);
}//end function
 
// ------------------------------------------------------------------------------
//      DB UPDATE
//          fncSwUserDBUpdate($mySqlConnObj,$clsSwUser)
// ------------------------------------------------------------------------------
function fncSwUserDBUpdate($mySqlConnObj,$clsSwUser){
    //ﾌﾟﾛﾊﾟﾃｨｾｯﾄ
    fncSwUserSetProperty($clsSwUser);
    //ﾃﾞｰﾀ管理ｸﾗｽ DbUpdate
    $clsSwUser->clsSwUserDbUpdate($mySqlConnObj);
}//end function
 
// ------------------------------------------------------------------------------
//      DB DELETE
//          fncSwUserDBDelete($mySqlConnObj,$clsSwUser)
// ------------------------------------------------------------------------------
function fncSwUserDBDelete($mySqlConnObj,$clsSwUser){
    //ﾌﾟﾛﾊﾟﾃｨｾｯﾄ
    fncSwUserSetProperty($clsSwUser);
    //ﾃﾞｰﾀ管理ｸﾗｽ DbDelete
    $clsSwUser->clsSwUserDbDelete($mySqlConnObj);
}//end function


// ------------------------------------------------------------------------------
//      ﾌﾟﾛﾊﾟﾃｨGet
//          fncSwUserLoginInfoGetProperty($clsSwUserLoginInfo)
// ------------------------------------------------------------------------------
function fncSwUserLoginInfoGetProperty($clsSwUserLoginInfo){
    global  $fdtUserLoginId;
    global  $fdtUserId;
    global  $fdtUserLoginDate;
 
    //ﾌﾟﾛﾊﾟﾃｨGet
    $fdtUserLoginId = $clsSwUserLoginInfo->clsSwUserLoginInfoGetUserLoginId();
    $fdtUserId = $clsSwUserLoginInfo->clsSwUserLoginInfoGetUserId();
    $fdtUserLoginDate = $clsSwUserLoginInfo->clsSwUserLoginInfoGetUserLoginDate();
}//end function
 
// ------------------------------------------------------------------------------
//      ﾌﾟﾛﾊﾟﾃｨSet
//          fncSwUserLoginInfoSetProperty($clsSwUserLoginInfo)
// ------------------------------------------------------------------------------
function fncSwUserLoginInfoSetProperty($clsSwUserLoginInfo){
    global  $fdtUserLoginId;
    global  $fdtUserId;
    global  $fdtUserLoginDate;
 
    //ﾌﾟﾛﾊﾟﾃｨSet
    $clsSwUserLoginInfo->clsSwUserLoginInfoSetUserLoginId($fdtUserLoginId);
    $clsSwUserLoginInfo->clsSwUserLoginInfoSetUserId($fdtUserId);
    $clsSwUserLoginInfo->clsSwUserLoginInfoSetUserLoginDate($fdtUserLoginDate);
}//end function
 
// ------------------------------------------------------------------------------
//      DB INSERT
//          fncSwUserLoginInfoDBInsert($mySqlConnObj,$clsSwUserLoginInfo)
// ------------------------------------------------------------------------------
function fncSwUserLoginInfoDBInsert($mySqlConnObj,$clsSwUserLoginInfo){
 
    //ﾌﾟﾛﾊﾟﾃｨｾｯﾄ
    fncSwUserLoginInfoSetProperty($clsSwUserLoginInfo);
    //ﾃﾞｰﾀ管理ｸﾗｽ DbInsert
    $clsSwUserLoginInfo->clsSwUserLoginInfoDbInsert($mySqlConnObj);
}//end function
 
// ------------------------------------------------------------------------------
//      DB UPDATE
//          fncSwUserLoginInfoDBUpdate($mySqlConnObj,$clsSwUserLoginInfo)
// ------------------------------------------------------------------------------
function fncSwUserLoginInfoDBUpdate($mySqlConnObj,$clsSwUserLoginInfo){
    //ﾌﾟﾛﾊﾟﾃｨｾｯﾄ
    fncSwUserLoginInfoSetProperty($clsSwUserLoginInfo);
    //ﾃﾞｰﾀ管理ｸﾗｽ DbUpdate
    $clsSwUserLoginInfo->clsSwUserLoginInfoDbUpdate($mySqlConnObj);
}//end function
 
// ------------------------------------------------------------------------------
//      DB DELETE
//          fncSwUserLoginInfoDBDelete($mySqlConnObj,$clsSwUserLoginInfo)
// ------------------------------------------------------------------------------
function fncSwUserLoginInfoDBDelete($mySqlConnObj,$clsSwUserLoginInfo){
    //ﾌﾟﾛﾊﾟﾃｨｾｯﾄ
    fncSwUserLoginInfoSetProperty($clsSwUserLoginInfo);
    //ﾃﾞｰﾀ管理ｸﾗｽ DbDelete
    $clsSwUserLoginInfo->clsSwUserLoginInfoDbDeleteFromUserId($mySqlConnObj);
}//end function

// ------------------------------------------------------------------------------
?>
