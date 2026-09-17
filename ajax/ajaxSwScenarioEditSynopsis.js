// ------------------------------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//		シノプシス
//		ajaxSwSynopsis.js
//		
//    	charset=UTF-8
// ------------------------------------------------------------------------------
// ------------------------------------------------------------------------------
//	form 制御
// ------------------------------------------------------------------------------
jQuery(document).ready(function() {

});

// ------------------------------------------------------------------------------
//		ﾃﾞｰﾀﾘｽﾄ	取得 jQuery ajax 
// ------------------------------------------------------------------------------
	function fncMakeSwSynopsisList(frm){
		jQuery(function($){
			var $form = $(frm);
			$phppath = "./ajax/ajaxSwScenarioEditSynopsis.php";
			$.ajax({
				async:false,
				type: "POST",
				url: $phppath,
				data: $form.serialize()
					+ "&SubMode=SwSynopsisList",
				success: function(result){
					$("#side_list_area").html(result);
				},
				error:function(result){
					alert(result);
				},
			});
		});
	}
// ------------------------------------------------------------------------------
//		ﾃﾞｰﾀﾘｽﾄ	click ｲﾍﾞﾝﾄ
// ------------------------------------------------------------------------------
function fncSelectSwSynopsis(valSynopsisId){
	$('#fdtSynopsisId').val(valSynopsisId);
	$('#SubmitMode').val('SELECT');
	$('#frmSwSynopsis').submit();
}
// ------------------------------------------------------------------------------
//		ﾎﾞﾀﾝが押されたときの制御
// ------------------------------------------------------------------------------
function fncSwSynopsisSubmit(frm,valSubmitMode,valMode,valMsg){
	var strMessage = valMsg + '　実行しますか？';
	if(valMode == 'TRUE'){
			//ﾀﾞｲｱﾛｸﾞを表示する
		bootbox.dialog({
			message: strMessage,
			title: "ScenarioWriterCafe",
			buttons: {
				success: {
					label: "Cancel",
					className: "btn-success",
					callback: function() {
						return;
					}
				},
				danger: {
					label: valMsg,
					className: "btn-danger",
					callback: function() {
						frm.SubmitMode.value = valSubmitMode;
						frm.submit();
						return true;
					}
				},
			}
		});
	}else{
		//何も聞かずにsubmitする
		frm.SubmitMode.value = valSubmitMode;
		frm.submit();
		return true;
	}
}
