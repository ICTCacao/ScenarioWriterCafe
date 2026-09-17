// ------------------------------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//		
//		ajaxSwScenarioView.js
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
function fncReadScenario(valScenarioId,valLoginId){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		//php path
		$phppath = "./ajax/ajaxSwScenarioView.php";

		//ajax
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: "id="+valScenarioId+"&loginId="+valLoginId+"&Submode=scene_index",
			success: function(result){
				$("#scene-index-area").html(result);
			},
			error:function(result){
				alert(result);
			},
		});
		//ajax
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: "id="+valScenarioId+"&loginId="+valLoginId+"&Submode=scenario_line",
			success: function(result){
				$("#scenario-area").html(result);
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}//end function
