// ------------------------------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//		
//		ajaxSwScenario.js
//		
//    	charset=UTF-8
// ------------------------------------------------------------------------------
// ------------------------------------------------------------------------------
//	form 制御
// ------------------------------------------------------------------------------
jQuery(document).ready(function() {
	//selectbox onchange　ｲﾍﾞﾝﾄ


});

// ------------------------------------------------------------------------------
//		ﾃﾞｰﾀﾘｽﾄ	取得 jQuery ajax 
// ------------------------------------------------------------------------------
	function fncMakeSwScenarioSelectList(frm){
		jQuery(function($){
			var $form = $(frm);
			$phppath = "./ajax/ajaxSwScenario.php";
			$.ajax({
				async:false,
				type: "POST",
				url: $phppath,
				data: $form.serialize()
					+ "&SubMode=SwScenarioList",
				success: function(result){
					$("#ScenarioSelectList").html(result);
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
function fncSelectSwScenario(valScenarioId){
	$('#fdtScenarioId').val(valScenarioId);
	$('#SubmitMode').val('SELECT');
	$('#frmSwScenario').submit();
}
// ------------------------------------------------------------------------------
//		ﾎﾞﾀﾝが押されたときの制御
// ------------------------------------------------------------------------------
function fncNewSwScenarioInsert(frm,valSubmitMode,valMode,valMsg){

	if ( valSubmitMode != 'RESET'){
		//必須項目チェック
		if (AjaxFunc_NullCheck(frm,'fdtScenarioTitle','タイトル') == false ){
			return false;
		}
	}

	var strMessage = valMsg + '　実行しますか？';
	if(valMode == 'TRUE'){
			//ﾀﾞｲｱﾛｸﾞを表示する
		bootbox.dialog({
			message: strMessage,
			title: "",
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
						jQuery(function($){
							var $form = $(frm);
							$phppath = "./ajax/ajaxSwScenario.php";
							$.ajax({
								async:false,
								type: "POST",
								url: $phppath,
								data: $form.serialize()
									+ "&SubMode=InsertNewScenario",
								success: function(result){
									$("#retMsg").html(result);
									//成功したらHOMEに戻る
									frm.action = "./swScenarioSelect.php";
									frm.target = "_self";
									frm.submit();
								},
								error:function(result){
									alert(result);
								},
							});
						});
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

// ------------------------------------------------------------------------------
//		ﾎﾞﾀﾝが押されたときの制御
// ------------------------------------------------------------------------------
function fncNewSwScenarioSubmit(frm,valSubmitMode,valMode,valMsg){

	//必須項目チェック
	if (AjaxFunc_NullCheck(frm,'fdtScenarioTitle','タイトル') == false ){
		return false;
	}

	var strMessage = valMsg + '　実行しますか？';
	if(valMode == 'TRUE'){
			//ﾀﾞｲｱﾛｸﾞを表示する
		bootbox.dialog({
			message: strMessage,
			title: "",
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

// ------------------------------------------------------------------------------
//		Scenario 選択　ScenarioEdit起動
// ------------------------------------------------------------------------------
function fncSelectSwScenario(frm,valScenarioId){

	$('#fdtScenarioId').val(valScenarioId);
	$('#SubmitMode').val('SELECT');

    frm.action = "./swScenarioEdit.php";
    frm.target = "_self";
    frm.submit();

}