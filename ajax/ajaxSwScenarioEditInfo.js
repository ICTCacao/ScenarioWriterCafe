// ------------------------------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//		シナリオ情報更新
//		ajaxSwScenarioEditInfo.js
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
//		ﾎﾞﾀﾝが押されたときの制御
// ------------------------------------------------------------------------------
function fncSwScenarioSubmit(frm,valSubmitMode,valMode,valMsg){

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
						//SubmitModeを設定
						$('#SubmitMode').val(valSubmitMode);
						//--------------------------------------------------------
						//	jQuery Ajax で更新処理
						//--------------------------------------------------------
						jQuery(function($){
							var $form = $(frm);
							$phppath = "./ajax/ajaxSwScenarioEditInfo.php";
							var fd = new FormData($form[0]);
							$.ajax({
								async:false,	//非同期=true，同期=false
								type: "POST",
								url: $phppath,
								processData: false,
								contentType: false,
								data: fd,
								dataType: 'html',
								success: function(result){
									//$("#retResult").html(result);
									if(result != ''){
										bootbox.alert(result, function() {
		  							});
									}
								},
								error:function(result){
									alert(result);
								},
							});
						});
						//--------------------------------------------------------
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
function fncSwScenarioSubmitDelete(frm){

	//必須項目チェック
	if (AjaxFunc_NullCheck(frm,'fdtScenarioTitle','タイトル') == false ){
		return false;
	}

	var strMessage = 'シナリオ全体を削除します。場面や登場人物、台詞等も全て削除します。　削除しますか？';
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
					label: 'シナリオ削除',
					className: "btn-danger",
					callback: function() {
						//SubmitModeを設定
						$('#SubmitMode').val('DELETE');
						//--------------------------------------------------------
						//	jQuery Ajax で更新処理
						//--------------------------------------------------------
						jQuery(function($){
							var $form = $(frm);
							$phppath = "./ajax/ajaxSwScenarioEditInfo.php";
							$.ajax({
								async:false,	//非同期=true，同期=false
								type: "POST",
								url: $phppath,
								data: $form.serialize(),
								success: function(result){
									$("#retResult").val(result);
									if ( result == 'DELETE'){
										frm.action = "./swScenarioSelect.php";
										frm.target = "_self";
										frm.submit();
									}
								},
								error:function(result){
									alert(result);
								},
							});
						});
						//--------------------------------------------------------
					}
				},
			}
		});
}
// ------------------------------------------------------------------------------
//		ﾎﾞﾀﾝが押されたときの制御
// ------------------------------------------------------------------------------
function fncSwScenarioSubmitCopy(frm){

	//必須項目チェック
	if (AjaxFunc_NullCheck(frm,'fdtScenarioTitle','タイトル') == false ){
		return false;
	}

	var strMessage = 'シナリオ全体を複写します。場面や登場人物、台詞等も全て複写します。　複写しますか？';
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
					label: 'シナリオ複写',
					className: "btn-danger",
					callback: function() {
						//SubmitModeを設定
						$('#SubmitMode').val('COPY');
						//--------------------------------------------------------
						//	jQuery Ajax で更新処理
						//--------------------------------------------------------
						jQuery(function($){
							var $form = $(frm);
							$phppath = "./ajax/ajaxSwScenarioEditInfo.php";
							$.ajax({
								async:false,	//非同期=true，同期=false
								type: "POST",
								url: $phppath,
								data: $form.serialize(),
								success: function(result){
									$("#retResult").val(result);
									if ( result == 'COPY'){
										frm.action = "./swScenarioSelect.php";
										frm.target = "_self";
										frm.submit();
									}
								},
								error:function(result){
									alert(result);
								},
							});
						});
						//--------------------------------------------------------
					}
				},
			}
		});
}

// ------------------------------------------------------------------------------
//		Scenario 選択　ScenarioEdit起動
// ------------------------------------------------------------------------------
function fncSelectSwScenario(frm,valScenarioId){

	$('#fdtScenarioId').val(valScenarioId);

    frm.action = "./swScenarioEdit.php";
    frm.target = "_self";
    frm.submit();

}