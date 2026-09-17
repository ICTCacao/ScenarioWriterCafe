<?php
// -------------------------------------------------------------------
//
//		ログインユーザーの取得（旧: 管理者ﾁｪｯｸ。2026-09 に管理者機能を廃止）
// 		swCheckAdmin.php
//
//	Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
// -------------------------------------------------------------------
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
	//ﾌﾟﾛﾊﾟﾃｨGet
	$fdtUserName = $clsSwUser->clsSwUserGetUserName();    //ユーザー名
	if( $fdtUserName == 'guestuser'){
		define("SW_GUEST",true);//ゲスト
	}else{
		define("SW_GUEST",false);
	}
	$fdtUserMailad = $clsSwUser->clsSwUserGetUserMailad();//ﾒｰﾙｱﾄﾞﾚｽ


	//2026-09 単独利用前提のため管理者(SW_ADMIN)判定を廃止。互換のため定数だけ残す。
	define("SW_ADMIN",false);
	return	false;

// -------------------------------------------------------------------
?>

