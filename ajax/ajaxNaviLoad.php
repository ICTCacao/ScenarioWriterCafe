<?php
//	------------------------------------------------------------------------------
//
//	Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//			WebSystemAjax
//
//			AjaxNaviLoad.php
//
//	------------------------------------------------------------------------------

	//MAIN PROC
	fncMainProc();
exit;

//--------------------------------------------------------------------------------
// MAIN PROCEDUR
//	fncMainProc($mySqlConnObj)
//--------------------------------------------------------------------------------
function fncMainProc(){

	$retNaviHtml = fncMakeNavi();

	// 出力charsetをEUC-JPに指定
	//mb_http_output( 'UTF-8' );
	// 出力
	//header ("Content-Type: text/html; charset=UTF-8");
	echo($retNaviHtml);

}


// ------------------------------------------------------------------------------
// MakeNavi
// ------------------------------------------------------------------------------
function fncMakeNavi(){
	
	$myNaviHtml = <<<END_OF_HTML
	
    <nav class="navbar navbar-default navbar-expand fixed-top" role="banner">
        <div class="container-fluid">
            <a class="navbar-brand" href="./swUserLogin.html"><img src="./img/logo.png" height="30"></a>
            <ul class="nav navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="./swUserLogin.html">ログイン</a></li>
            </ul>
        </div>
    </nav>


END_OF_HTML;

	return	$myNaviHtml;



}//end function

?>
