<?php
//	------------------------------------------------------------------------------
//
//	Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//			ScenarioWriterCafeパスワード変更
//
//			SwUserChangePassword.php
//	------------------------------------------------------------------------------
// ------------------------------------------------------------------------------
	//定数読み込み
	include_once("./sw_config/swConstant.php");
	//DB接続ｸﾗｽの初期化
	include_once("./include/ConnectMySQL.php");
// ------------------------------------------------------------------------------
	//ｾｯｼｮﾝ管理
	include_once("./include/swAccept.php");
	//管理者チェック
	include_once("./include/swCheckAdmin.php");
// ------------------------------------------------------------------------------
	//ﾃﾞﾌｫﾙﾄｱｸｼｮﾝ
	$ThisPHP = 'swtUserChangePassword.php';

	//共通関数をｲﾝｸﾙｰﾄﾞ
	include_once("./include/swFunc.php");

	// ﾍｯﾀﾞ表示
	$HtmlTitle = "パスワード変更";
	$myStyle = 'html';
	include_once("./include/swHeader.php");

	//ﾌｫｰﾑのﾃﾞｰﾀを読み込む
	fncGetPostItems();

	//MainProcedure
	fncMainProc($mySqlConnObj);

	exit();

exit;
// ------------------------------------------------------------------------------
//
//      フォームのデータを読み込む
//          fncGetPostItems()
// ------------------------------------------------------------------------------
function fncGetPostItems(){
    //global変数
    global  $fdtUserLoginId;
    global  $fdtUserLoginDate;

	//POSTされた要素ﾛｸﾞｲﾝ情報を取得
	$fdtUserLoginId = swFunc_GetPostData('fdtUserLoginId');              //ﾛｸﾞｲﾝID
	$fdtUserLoginDate = swFunc_GetPostData('fdtUserLoginDate');          //ﾛｸﾞｲﾝ日時

}

//--------------------------------------------------------------------------------
// MAIN PROCEDUR
//	fncMainProc($mySqlConnObj)
//--------------------------------------------------------------------------------
function fncMainProc($mySqlConnObj){
    global  $fdtUserLoginId;
    global  $fdtUserLoginDate;

	//ﾛｸﾞｲﾝ情報からﾒｰﾙｱﾄﾞﾚｽを取得
	//ﾃﾞｰﾀ管理ｸﾗｽ
	include_once("./class/clsSwUserLoginInfo.php");
	$clsSwUserLoginInfo = new clsSwUserLoginInfo();
	//ﾃﾞｰﾀ管理ｸﾗｽの初期化
	$clsSwUserLoginInfo->clsSwUserLoginInfoInit($mySqlConnObj,$fdtUserLoginId);
	//USER_ID取得
	$fdtUserId = $clsSwUserLoginInfo->clsSwUserLoginInfoGetUserId();
	
	//ﾃﾞｰﾀ管理ｸﾗｽ
	include_once("./class/clsSwUser.php");
	$clsSwUser = new clsSwUser();
	//ﾃﾞｰﾀ管理ｸﾗｽの初期化
	$clsSwUser->clsSwUserInit($mySqlConnObj,$fdtUserId);
	//メールアドレス
	$fdtUserMailad = $clsSwUser->clsSwUserGetUserMailad();
	//ユーザー名
	$fdtUserName = $clsSwUser->clsSwUserGetUserName();
	
	print <<<END_OF_HTML

END_OF_HTML;
	include_once("./include/swMenuBar.php");
	swMenuBar_Print('./include/swDropDownMenu.php', 'frmUserPassword', 'パスワード変更', array(), $fdtUserName);
	print <<<END_OF_HTML
	
		<!-- main -->
		<main>
			<div class="container">
				<div class="intro-text">
					<!-- ﾌｫｰﾑ と ﾘｽﾄ -->
					<div class="row">
						<div class="col-sm-11 row-0">
							<div class="jumbotron" style="margin-top: 100px;">
							<h4>登録したメールアドレス {$fdtUserMailad} に対する登録名とパスワードを変更できます。</h4>
							<form class="" role="form" name="frmUserPassword" id="frmUserPassword" method="POST" action="">
								<input type="hidden" name="SubmitMode" id="SubmitMode" value="">
								<input type="hidden" name="fdtUserLoginId" id="fdtUserLoginId" value="$fdtUserLoginId">
								<input type="hidden" name="fdtUserLoginDate" id="fdtUserLoginDate" value="$fdtUserLoginDate">
								<div class="row row-0">
									<label for="fdtUserName" class="col-form-label col-sm-4">登録名</label>
									<div class="col-sm-6">
									<input type="text" 
										class="form-control form-control-sm"
										id="fdtUserName" name="fdtUserName"
										value="$fdtUserName"
										required="required"
										placeholder="登録名">
									</div>
								</div>
								<div class="row row-0">
									<label for="fdtUserPasswd" class="col-form-label col-sm-4">新しいパスワード</label>
									<div class="col-sm-4">
									<input type="password" 
										class="form-control form-control-sm"
										id="fdtUserPasswd" name="fdtUserPasswd"
										required="required"
										placeholder="新しいパスワード">
									</div>
								</div>
								<div class="row row-0">
									<label for="repUserPasswd" class="col-form-label col-sm-4">新しいパスワード（確認）</label>
									<div class="col-sm-4">
									<input type="password" 
										class="form-control form-control-sm"
										id="repUserPasswd" name="repUserPasswd"
										required="required"
										placeholder="新しいパスワード">
									</div>
								</div>
								<div class="row row-0">
									<button type="button" class="btn btn-success offset-sm-3"
										onClick="ajaxUserLogin_ChangePassword(frmUserPassword);">パスワードを変更する
									</button>
								</div>
								<div>
									<!--処理結果表示位置--><span id="retMsg" class="text-center"></span>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</main>
	
	<script type="text/javascript" src="./ajax/ajaxUserLogin.js"></script>
  </body>
</html>
END_OF_HTML;

}

?>