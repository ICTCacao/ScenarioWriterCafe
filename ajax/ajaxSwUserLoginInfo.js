// ------------------------------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//		USERログイン情報
//		ajaxSwUserLoginInfo.js
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
	function fncMakeSwUserLoginInfoList(frm){
		jQuery(function($){
			var $form = $(frm);
			$phppath = "./ajax/ajaxSwUserLoginInfo.php";
			$.ajax({
				async:false,
				type: "POST",
				url: $phppath,
				data: $form.serialize()
					+ "&SubMode=SwUserLoginInfoList",
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
function fncSelectSwUserLoginInfo(valUserLoginId){
	$('#fdtUserLoginId').val(valUserLoginId);
	$('#SubmitMode').val('SELECT');
	$('#frmSwUserLoginInfo').submit();
}
// ------------------------------------------------------------------------------
//		ﾎﾞﾀﾝが押されたときの制御
// ------------------------------------------------------------------------------
function fncSwUserLoginInfoSubmit(frm,valSubmitMode,valMode,valMsg){
	var strMessage = valMsg + '　実行しますか？';
	if(valMode == 'TRUE'){
			//ﾀﾞｲｱﾛｸﾞを表示する
		bootbox.dialog({
			message: strMessage,
			title: "USERログイン情報",
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
