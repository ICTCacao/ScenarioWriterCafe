// ------------------------------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//		
//		ajaxSwScenarioDownLoadText.js
//		
//    	charset=UTF-8
// ------------------------------------------------------------------------------
// ------------------------------------------------------------------------------
//	form 制御
// ------------------------------------------------------------------------------
jQuery(document).ready(function() {

});

// ------------------------------------------------------------------------------
//		シナリオ表示 jQuery ajax 
// ------------------------------------------------------------------------------
function fncScenarioDownLoadText(valScenarioId,valLoginId){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		//php path
		$phppath = "./ajax/ajaxSwScenarioDownLoadText.php";
		//ajax
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: "id="+valScenarioId+"&loginId="+valLoginId,
			success: function(result){
				$("#result").html(result);
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}//end function
