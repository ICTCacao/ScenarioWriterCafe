// ------------------------------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//		USER_INFO
//		ajaxSwUser.js
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
	function fncMakeSwUserList(frm){
		jQuery(function($){
			var $form = $(frm);
			$phppath = "./ajax/ajaxSwUser.php";
			$.ajax({
				async:false,
				type: "POST",
				url: $phppath,
				data: $form.serialize()
					+ "&SubMode=SwUserList",
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
function fncSelectSwUser(valUserId){
	$('#fdtUserId').val(valUserId);
	$('#SubmitMode').val('SELECT');
	$('#frmSwUser').submit();
}
// ------------------------------------------------------------------------------
//		ﾎﾞﾀﾝが押されたときの制御
// ------------------------------------------------------------------------------
function fncSwUserSubmit(frm,valSubmitMode,valMode,valMsg){
	var strMessage = valMsg + '　実行しますか？';
	if(valMode == 'TRUE'){
			//ﾀﾞｲｱﾛｸﾞを表示する
		bootbox.dialog({
			message: strMessage,
			title: "USER_INFO",
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
