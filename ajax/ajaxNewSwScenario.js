// ------------------------------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//		新規シナリオ作成
//		ajaxNewSwScenario.js
//		
//    	charset=UTF-8
// ------------------------------------------------------------------------------
// ------------------------------------------------------------------------------
//	form 制御
// ------------------------------------------------------------------------------
jQuery(document).ready(function() {
	//selectbox onchange　ｲﾍﾞﾝﾄ
	$('#fdtMakuSuu').change(function() {
		fncMakeSceneSuu(frmSwScenario);
	});
	$('#fdtBaSuu').change(function() {
		fncMakeSceneSuu(frmSwScenario);
	});
});

// ------------------------------------------------------------------------------
//		シーンの数を表示する
// ------------------------------------------------------------------------------
function fncMakeSceneSuu(frm){
	var sNum = $('#fdtMakuSuu').val();
	var cNum = $('#fdtBaSuu').val();
	var SceneSuu = sNum * cNum;
	SceneSuu = SceneSuu + '場面'
	$('#SceneSuu').html(SceneSuu);
}
// ------------------------------------------------------------------------------
//		ﾎﾞﾀﾝが押されたときの制御
// ------------------------------------------------------------------------------
function fncNewSwScenarioInsert(frm,valSubmitMode,valMode,valMsg){

	//必須項目チェック
	if (AjaxFunc_NullCheck(frm,'fdtScenarioTitle','タイトル') == false ){
		return false;
	}

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
						jQuery(function($){
							var $form = $(frm);
							$phppath = "./ajax/ajaxNewSwScenario.php";
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
