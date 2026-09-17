<?php
//	------------------------------------------------------------------------------
//
//	Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//			ScenarioWriterCafe footer
//
//			AjaxFooterLoad.php
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

	$retNaviHtml = fncMakeFooter();

	// 出力charsetをEUC-JPに指定
	//mb_http_output( 'UTF-8' );
	// 出力
	//header ("Content-Type: text/html; charset=UTF-8");
	echo($retNaviHtml);

}


// ------------------------------------------------------------------------------
// MakeNavi
// ------------------------------------------------------------------------------
function fncMakeFooter(){

	$myNaviHtml = <<<END_OF_HTML

		<div class="copyright">

      		<div class="text-center">Copyright &copy; 2026 ictcacao.com Released under the MIT License (see LICENSE).</div>

		</div>

END_OF_HTML;

	return	$myNaviHtml;



}//end function

?>
