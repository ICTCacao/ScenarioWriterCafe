// ------------------------------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//		場面設定
//		ajaxSwScenarioEditScene.js
//		
//    	charset=UTF-8
// ------------------------------------------------------------------------------
// ------------------------------------------------------------------------------
//	form 制御
// ------------------------------------------------------------------------------
jQuery(document).ready(function() {


});
// ------------------------------------------------------------------------------
//		総時間の表示 jQuery ajax 
// ------------------------------------------------------------------------------
function fncGetTotalTime(frm){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditScene.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=GetSceneTime",
			success: function(result){
				$("#total_time").html(result);
			},
		});
	});// end jQuery(function($)
}
// ------------------------------------------------------------------------------
//		場面ﾘｽﾄ表示 jQuery ajax 
// ------------------------------------------------------------------------------
function fncReadSwSceneList(frm){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		//スクロール位置
		var scpos = $("#listpos").text();

		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditScene.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=ReadSwSceneList",
			success: function(result){
				$("#SceneList").html(result);
			},
			error:function(result){
				alert(result);
			},
		});
			//スクロール位置を復元
			$("#Scenes").scrollTop(scpos);
	});// end jQuery(function($)
	
	fncGetTotalTime(frm);
	
}//end function

// ------------------------------------------------------------------------------
//		場面 MOVE BEFORE		一つ前に移動
// ------------------------------------------------------------------------------
function fncMoveSceneBefore(frm,valId){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		$('#SubmitMode').val('MOVE_BEFORE');
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditScene.php";
		//ひとつ前にする
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=MoveSceneBefore&tgtId="+ valId,
			success: function(result){
				// リスト表示を更新
				fncReadSwSceneList(frm);
			},
		});
	});// end jQuery(function($)
}
// ------------------------------------------------------------------------------
//		場面 MOVE AFTER		一つ後に移動
// ------------------------------------------------------------------------------
function fncMoveSceneAfter(frm,valId){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		$('#SubmitMode').val('UPDATE');
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditScene.php";
		//ひとつ前にする
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=MoveSceneAfter&tgtId="+ valId,
			success: function(result){
				// リスト表示を更新
				fncReadSwSceneList(frm);
			},
		});
	});// end jQuery(function($)
}


// ------------------------------------------------------------------------------
//		新規場面登録エリア表示
// ------------------------------------------------------------------------------
function fncNewSceneInit(frm){
	//場面編集エリアがあったらもとに戻す
	if($('#edit_scene')[0] ){
		//場面編集エリアがあったらもとに戻す
		var EditSceneId = $('#SelectSceneId').val();
		fncSceneEditClose(frm,EditSceneId);
	}
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditScene.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=NewSceneInit",
			success: function(result){
				$('#edit_new').html(result);
			},
		});
	});// end jQuery(function($)	
}

// ------------------------------------------------------------------------------
//		新規場面登録エリアCLOSE
// ------------------------------------------------------------------------------
function fncNewSceneEditClose(frm){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditScene.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=CloseNewSceneEdit",
			success: function(result){
				$('#edit_new').html(result);
			},
		});
	});// end jQuery(function($)	
}

// ------------------------------------------------------------------------------
//		場面更新 jQuery ajax 
// ------------------------------------------------------------------------------
function fncSceneEditSubmit(frm,valSubmitMode){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		//SubmitFMode設定
		$('#SubmitMode').val(valSubmitMode);
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditScene.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=SceneEditSubmit",
			success: function(result){
				//新キャラ登録エリアCLOSE
				fncNewSceneEditClose(frm);
				// シナリオ表示を更新
				fncReadSwSceneList(frm);
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}//end function

// ------------------------------------------------------------------------------
//		場面選択
// ------------------------------------------------------------------------------
function fncSelectScene(frm,valSceneId){
	//新規編集エリアがあったら消す
	if($('#edit_new')[0] ){
		//新キャラ登録エリアCLOSE
		fncNewSceneEditClose(frm);
	}
	//編集エリアがあったらもとに戻す
	if($('#edit_scene')[0] ){
		//場面編集エリアがあったらもとに戻す
		var EditSceneId = $('#SelectSceneId').val();
		fncSceneEditClose(frm,EditSceneId);
		//場面編集エリア生成
		fncMakeEditScene(frm,valSceneId);
	}else{
		//場面編集エリア生成
		fncMakeEditScene(frm,valSceneId);
	}
}
// ------------------------------------------------------------------------------
//		場面表示
// ------------------------------------------------------------------------------
function fncSetSceneById(frm){
	//編集中のキャラクターID
	var EditSceneId = $('#SelectSceneId').val();
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditScene.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=SetSceneById",
			success: function(result){
				var tgtID = '#'+'edit_'+EditSceneId;
				$(tgtID).html(result);
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}
// ------------------------------------------------------------------------------
//		場面編集エリア生成
// ------------------------------------------------------------------------------
function fncMakeEditScene(frm,valSceneId){
	//処理ﾓｰﾄﾞをSELECTにする
	$('#SubmitMode').val('SELECT');
	//編集するIDをセット
	$('#SelectSceneId').val(valSceneId);
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditScene.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=SetSceneEditForm",
			success: function(result){
				var edit_area = '#'+'edit_'+valSceneId;
				$(edit_area).html(result);
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}
// ------------------------------------------------------------------------------
//		場面更新エリアCLOSE
// ------------------------------------------------------------------------------
function fncSceneEditClose(frm,valSceneId){
	//処理ﾓｰﾄﾞをNULLにする
	$('#SubmitMode').val('');
	//編集するIDをセット
	$('#SelectSceneId').val(valSceneId);
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditScene.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=CloseSceneEditForm",
			success: function(result){
				var tgtID = '#'+'edit_'+valSceneId;
				$(tgtID).html(result);
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}

