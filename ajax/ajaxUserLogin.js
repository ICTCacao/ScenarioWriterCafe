// ----------------------------------------------------------------------------- 
//                
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).    
//
//		共通関数
//
//     AjaxUserLogin.js
// ----------------------------------------------------------------------------- 

// ------------------------------------------------------------------------------
//      EnterでLogin
// ------------------------------------------------------------------------------
function ajaxUserLogin_ReturnLogin(frm,evt){
		evt = (evt) ? evt : event;
		var charCode=(evt.charCode) ? evt.charCode :
			((evt.which) ? evt.which : evt.keyCode);
		if ( Number(charCode) == 13 || Number(charCode) == 3) {
			//EnterでLogin
			ajaxUserLogin_Login(frm);
		} else {
			return false;
		}
}

// ------------------------------------------------------------------------------
//      ajaxUserLogin_Login
// ------------------------------------------------------------------------------
function ajaxUserLogin_Login(frm){
	//必須項目チェック
    if (AjaxFunc_NullCheck(frm,'fdtUserMailad','メールアドレス') == false ){
        return false;
    }
    if (AjaxFunc_NullCheck(frm,'fdtUserPasswd','パスワード') == false ){
        return false;
    }
	// メールアドレスかどうかチェックする
    if (AjaxFunc_CheckMail(frm,'fdtUserMailad') == false ){
        return false;
    }

	//--------------------------------------------------------
	//	jQuery Ajax
	//--------------------------------------------------------
    jQuery(function($){
        var $form = $(frm);
        $phppath = "./ajax/ajaxUserLogin.php";
        $.ajax({
            async:false,	//非同期=true，同期=false
            type: "POST",
            url: $phppath,
            data: $form.serialize()
                + "&SubMode=LOGIN",
            success: function(result){
                $("#retMsg").html(result);
            },
            error:function(result){
                alert(result);
            },
        });
	});
    //--------------------------------------------------------
    
	if ( AjaxFunc_NullCheckNoMsg(frm,'retResult') == false){
		frm.action = "./swScenarioSelect.php";
		frm.target = "_self";
		frm.submit();
	}else{
		var strMsg = frm.elements['retResult'].value;
		bootbox.alert(strMsg, function() {
		  	});
	}
	return true;
    
}

// ------------------------------------------------------------------------------
//      ajaxUserLogin_ResetPasswd
// ------------------------------------------------------------------------------
function ajaxUserLogin_ResetPasswd(frm){
	//必須項目チェック
    if (AjaxFunc_NullCheck(frm,'fdtUserMailad','メールアドレス') == false ){
        return false;
    }
	// メールアドレスかどうかチェックする
    if (AjaxFunc_CheckMail(frm,'fdtUserMailad') == false ){
        return false;
    }
	//ﾀﾞｲｱﾛｸﾞを表示する
	var strMessage = 'パスワードをリセットしますか？';
	var valMsg = 'パスワードをリセット';
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
					//--------------------------------------------------------
					//	jQuery Ajax
					//--------------------------------------------------------
				    jQuery(function($){
				        var $form = $(frm);
				        $phppath = "./ajax/ajaxUserLogin.php";
				        $.ajax({
				            async:false,	//非同期=true，同期=false
				            type: "POST",
				            url: $phppath,
				            data: $form.serialize()
				                + "&SubMode=RESET_PASSWD",
				            success: function(result){
				                $("#retMsg").html(result);
				            },
				            error:function(result){
				                alert(result);
				            },
				        });
					});
				    //--------------------------------------------------------
				    
					if ( AjaxFunc_NullCheckNoMsg(frm,'retResult') == false){
						frm.action = "./swUserRequestResult.php";
						frm.target = "_blank";
						frm.submit();
					}else{
						var strMsg = frm.elements['retResult'].value;
						bootbox.alert(strMsg, function() {
						  	});
					}
					return true;

				}
			},
		}
	});

    
}

// ------------------------------------------------------------------------------
//      ajaxUserLogin_Changepasswd
// ------------------------------------------------------------------------------
function ajaxUserLogin_ChangePassword(frm){

	//必須項目チェック
    if (AjaxFunc_NullCheck(frm,'fdtUserPasswd','新しいパスワード') == false ){
        return false;
    }
    if (AjaxFunc_NullCheck(frm,'repUserPasswd','新しいパスワード(確認)') == false ){
        return false;
    }

	var newPasswd=frm.elements['fdtUserPasswd'].value;
	if (newPasswd.match(/[^0-9A-Za-z\_]+$/)) {
		bootbox.alert("【文字列エラー】<br />パスワードは、英数字と(_)アンダースコアで４文字以上12文字以内で入力してください", function() {
		});
		return false;
	}
	if (newPasswd.length < 4) {
		bootbox.alert("【文字数エラー】<br />パスワードは、英数字と(_)アンダースコアで４文字以上12文字以内で入力してください", function() {
		});
		return false;
	}
	if (newPasswd.length > 12) {
		bootbox.alert("【文字数オーバー】<br />パスワードは、英数字と(_)アンダースコアで４文字以上12文字以内で入力してください", function() {
		});
		return false;
	}

	var newPasswd=frm.elements['fdtUserPasswd'].value;
	var repPasswd=frm.elements['repUserPasswd'].value;
	if(newPasswd != repPasswd){
		bootbox.alert('パスワードが一致しません', function() {
		  	});
		  	frm.elements['fdtUserPasswd'].value = '';
		  	frm.elements['repUserPasswd'].value = '';
		  	return false;	}

    if (AjaxFunc_NullCheck(frm,'fdtUserName','登録名') == false ){
        return false;
    }

	//--------------------------------------------------------
	//	jQuery Ajax
	//--------------------------------------------------------
    jQuery(function($){
        var $form = $(frm);
        $phppath = "./ajax/ajaxUserLogin.php";
        $.ajax({
            async:false,	//非同期=true，同期=false
            type: "POST",
            url: $phppath,
            data: $form.serialize()
                + "&SubMode=CHANGE_PASSWD",
            success: function(result){
                $("#retMsg").html(result);
            },
            error:function(result){
                alert(result);
            },
        });
	});
    //--------------------------------------------------------
    
	if ( AjaxFunc_NullCheckNoMsg(frm,'retResult') == false){
	}else{
		var strMsg = frm.elements['retResult'].value;
		bootbox.alert(strMsg, function() {
		  	});
	}
	return true;
    
}
