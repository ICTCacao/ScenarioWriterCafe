<?php
//	------------------------------------------------------------------------------
//
//	Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//			ログアウト
//
//			swUserLogout.php
//
//	------------------------------------------------------------------------------
	//sessionの初期化
	session_name('scenario-writer-cafe');
	session_start();

	//session変数解除
	$_SESSION = array();

	//sessionクッキー削除
	if (ini_get("session.use_cookies")) {
	    $params = session_get_cookie_params();
	    //PHP8: session 開始後に session_name('名前') を呼ぶと false が返り setcookie('') が ValueError で落ちる。引数なし(getter)で現在の名前を取る
	    setcookie(session_name(), '', time() - 42000,
	        $params["path"], $params["domain"],
	        $params["secure"], $params["httponly"]
	    );
	}
	
	//session破壊
	session_destroy();

	//ﾛｸﾞｲﾝ画面表示
	header("Location: ./swUserLogin.html");
	
?>