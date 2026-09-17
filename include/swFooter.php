<?php
// ------------------------------------------------------------------------------
//
//		scenariowritercafe共通 footer
//				swFooter.php
//
//		Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
// ------------------------------------------------------------------------------

// ------------------------------------------------------------------------------
//
//	共通フッター
//
// ------------------------------------------------------------------------------
	//現在の日付を取得
	$today = getdate();
	$THIS_YEAR = sprintf( "%04d",$today['year']);

	if ( $THIS_YEAR == '2015'){
		$cp_year = '2015';
	}else{
		$cp_year = '2015-'.$THIS_YEAR;
	}

print <<<END_OF_HTML
	
	<div class="footer">
		<div class="container">
      		<div class="text-center">Copyright &copy; 2026 ictcacao.com Released under the MIT License (see LICENSE).</div>
		</div>
    </div>

END_OF_HTML;

?>
