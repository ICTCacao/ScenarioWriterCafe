// ------------------------------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//		オプション設定
//		ajaxUserOption.js
//		
//    	charset=UTF-8
// ------------------------------------------------------------------------------
// ------------------------------------------------------------------------------
//	form 制御
// ------------------------------------------------------------------------------
jQuery(document).ready(function() {


});

// ------------------------------------------------------------------------------
//		オプションﾘｽﾄ表示 jQuery ajax 
// ------------------------------------------------------------------------------
function fncReadUserOptionStyleList(frm){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		//スクロール位置
		var scpos = $("#listpos").text();

		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxUserOption.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=ReadUserOptionStyleList",
			success: function(result){
				$("#UserOptionStyleList").html(result);
			},
			error:function(result){
				alert(result);
			},
		});
			//スクロール位置を復元
			$("#UserOption").scrollTop(scpos);
	});// end jQuery(function($)
	
}//end function

// ------------------------------------------------------------------------------
//		オプション MOVE BEFORE		一つ前に移動
// ------------------------------------------------------------------------------
function fncMoveUserOptionStyleBefore(frm,valId){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		$('#SubmitMode').val('MOVE_BEFORE');
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxUserOption.php";
		//ひとつ前にする
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=MoveUserOptionStyleBefore&tgtId="+ valId,
			success: function(result){
				// リスト表示を更新
				fncReadUserOptionStyleList(frm);
			},
		});
	});// end jQuery(function($)
}
// ------------------------------------------------------------------------------
//		オプション MOVE AFTER		一つ後に移動
// ------------------------------------------------------------------------------
function fncMoveUserOptionStyleAfter(frm,valId){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		$('#SubmitMode').val('UPDATE');
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxUserOption.php";
		//ひとつ前にする
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=MoveUserOptionStyleAfter&tgtId="+ valId,
			success: function(result){
				// リスト表示を更新
				fncReadUserOptionStyleList(frm);
			},
		});
	});// end jQuery(function($)
}


// ------------------------------------------------------------------------------
//		新キャラ登録エリア表示
// ------------------------------------------------------------------------------
function fncNewUserOptionStyleInit(frm){
	//オプション編集エリアがあったらもとに戻す
	if($('#edit_user_option_style')[0] ){
		//オプション編集エリアがあったらもとに戻す
		var EditUserOptionId = $('#SelectUserOptionId').val();
		fncUserOptionStyleEditClose(frm,EditUserOptionId);
	}
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxUserOption.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=NewUserOptionStyleInit",
			success: function(result){
				$('#edit_new').html(result);
			},
		});
	});// end jQuery(function($)	
}

// ------------------------------------------------------------------------------
//		新キャラ登録エリアCLOSE
// ------------------------------------------------------------------------------
function fncNewUserOptionStyleEditClose(frm){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxUserOption.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=CloseNewUserOptionStyleEdit",
			success: function(result){
				$('#edit_new').html(result);
			},
		});
	});// end jQuery(function($)	
}

// ------------------------------------------------------------------------------
//		オプション更新 jQuery ajax 
// ------------------------------------------------------------------------------
function fncUserOptionStyleEditSubmit(frm,valSubmitMode){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		//SubmitFMode設定
		$('#SubmitMode').val(valSubmitMode);
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxUserOption.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=UserOptionStyleEditSubmit",
			success: function(result){
				//新スタイル登録エリアCLOSE
				fncNewUserOptionStyleEditClose(frm);
				// スタイル表示を更新
				fncReadUserOptionStyleList(frm);
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}//end function

// ------------------------------------------------------------------------------
//		オプション選択
// ------------------------------------------------------------------------------
function fncSelectUserOptionStyle(frm,valUserOptionId){
	//新規編集エリアがあったら消す
	if($('#edit_new')[0] ){
		//新キャラ登録エリアCLOSE
		fncNewUserOptionStyleEditClose(frm);
	}
	//編集エリアがあったらもとに戻す
	if($('#edit_user_option_style')[0] ){
		//オプション編集エリアがあったらもとに戻す
		var EditUserOptionId = $('#SelectUserOptionId').val();
		fncUserOptionStyleEditClose(frm,EditUserOptionId);
		//オプション編集エリア生成
		fncMakeEditUserOptionStyle(frm,valUserOptionId);
	}else{
		//オプション編集エリア生成
		fncMakeEditUserOptionStyle(frm,valUserOptionId);
	}
}
// ------------------------------------------------------------------------------
//		オプション表示
// ------------------------------------------------------------------------------
function fncSetUserOptionStyleById(frm){
	//編集中のキャラクターID
	var EditUserOptionId = $('#SelectUserOptionId').val();
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxUserOption.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=SetUserOptionStyleById",
			success: function(result){
				var tgtID = '#'+'edit_'+EditUserOptionId;
				$(tgtID).html(result);
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}
// ------------------------------------------------------------------------------
//		オプション編集エリア生成
// ------------------------------------------------------------------------------
function fncMakeEditUserOptionStyle(frm,valUserOptionId){
	//処理ﾓｰﾄﾞをSELECTにする
	$('#SubmitMode').val('SELECT');
	//編集するIDをセット
	$('#SelectUserOptionId').val(valUserOptionId);
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxUserOption.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=SetUserOptionStyleEditForm",
			success: function(result){
				var edit_area = '#'+'edit_'+valUserOptionId;
				$(edit_area).html(result);
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}
// ------------------------------------------------------------------------------
//		オプション更新エリアCLOSE
// ------------------------------------------------------------------------------
function fncUserOptionStyleEditClose(frm,valUserOptionId){
	//処理ﾓｰﾄﾞをNULLにする
	$('#SubmitMode').val('');
	//編集するIDをセット
	$('#SelectUserOptionId').val(valUserOptionId);
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxUserOption.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=CloseUserOptionStyleEditForm",
			success: function(result){
				var tgtID = '#'+'edit_'+valUserOptionId;
				$(tgtID).html(result);
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}

// ------------------------------------------------------------------------------
//		USER SETTING更新 jQuery ajax 
// ------------------------------------------------------------------------------
function fncUserOptionSettingSave(frm){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxUserOption.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=UserOptionSettingSave",
			success: function(result){
				//ﾀﾞｲｱﾛｸﾞを表示する
				bootbox.dialog({
					message: 'USER OPTION設定を保存しました',
					title: "ScenarioWriterCafe",
					buttons: {
						success: {
							label: "Close",
							className: "btn-success",
							callback: function() {
								return;
							}
						}
					}
				})
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}//end function


// ------------------------------------------------------------------------------
//		USER OPTION設定の即時保存（2026-09 追加）
//		文字数・「」ﾁｪｯｸの変更時に呼ばれる。ﾀﾞｲｱﾛｸﾞは出さず、右横に「保存しました」を短く表示する
// ------------------------------------------------------------------------------
function fncUserOptionSettingAutoSave(frm){
	var $form = $(frm);
	var ok = false;
	$.ajax({
		async: false,
		type: "POST",
		url: "./ajax/ajaxUserOption.php",
		data: $form.serialize() + "&SubMode=UserOptionSettingSave",
		success: function(){ ok = true; },
		error: function(){ ok = false; }
	});
	var $msg = $("#optionSaveMsg");
	$msg.stop(true, true).text(ok ? '保存しました' : '保存に失敗しました').css('opacity', 1);
	if (ok) { $msg.delay(1500).animate({opacity: 0}, 600); }
}
