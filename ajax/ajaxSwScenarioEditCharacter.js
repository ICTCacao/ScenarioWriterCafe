// ------------------------------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//		登場人物設定
//		ajaxSwScenarioEditCharacter.js
//		
//    	charset=UTF-8
// ------------------------------------------------------------------------------
// ------------------------------------------------------------------------------
//	form 制御
// ------------------------------------------------------------------------------
jQuery(document).ready(function() {


});
// ------------------------------------------------------------------------------
//		登場人物ﾘｽﾄ表示 jQuery ajax 
// ------------------------------------------------------------------------------
function fncReadSwCharacterList(frm){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		//スクロール位置
		var scpos = $("#listpos").text();

		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditCharacter.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=ReadSwCharacterList",
			success: function(result){
				$("#CharacterList").html(result);
			},
			error:function(result){
				alert(result);
			},
		});
			//スクロール位置を復元
			$("#Characters").scrollTop(scpos);
	});// end jQuery(function($)
	
}//end function

// ------------------------------------------------------------------------------
//		登場人物 MOVE BEFORE		一つ前に移動
// ------------------------------------------------------------------------------
function fncMoveCharacterBefore(frm,valId){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		$('#SubmitMode').val('MOVE_BEFORE');
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditCharacter.php";
		//ひとつ前にする
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=MoveCharacterBefore&tgtId="+ valId,
			success: function(result){
				// リスト表示を更新
				fncReadSwCharacterList(frm);
			},
		});
	});// end jQuery(function($)
}
// ------------------------------------------------------------------------------
//		登場人物 MOVE AFTER		一つ後に移動
// ------------------------------------------------------------------------------
function fncMoveCharacterAfter(frm,valId){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		$('#SubmitMode').val('UPDATE');
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditCharacter.php";
		//ひとつ前にする
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=MoveCharacterAfter&tgtId="+ valId,
			success: function(result){
				// リスト表示を更新
				fncReadSwCharacterList(frm);
			},
		});
	});// end jQuery(function($)
}


// ------------------------------------------------------------------------------
//		新キャラ登録エリア表示
// ------------------------------------------------------------------------------
function fncNewCharacterInit(frm){
	//登場人物編集エリアがあったらもとに戻す
	if($('#edit_character')[0] ){
		//登場人物編集エリアがあったらもとに戻す
		var EditCharacterId = $('#SelectCharacterId').val();
		fncCharacterEditClose(frm,EditCharacterId);
	}
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditCharacter.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=NewCharacterInit",
			success: function(result){
				$('#edit_new').html(result);
			},
		});
	});// end jQuery(function($)	
}

// ------------------------------------------------------------------------------
//		新キャラ登録エリアCLOSE
// ------------------------------------------------------------------------------
function fncNewCharacterEditClose(frm){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditCharacter.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=CloseNewCharacterEdit",
			success: function(result){
				$('#edit_new').html(result);
			},
		});
	});// end jQuery(function($)	
}

// ------------------------------------------------------------------------------
//		登場人物更新 jQuery ajax 
// ------------------------------------------------------------------------------
function fncCharacterEditSubmit(frm,valSubmitMode){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		//SubmitFMode設定
		$('#SubmitMode').val(valSubmitMode);
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditCharacter.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=CharacterEditSubmit",
			success: function(result){
				//新キャラ登録エリアCLOSE
				fncNewCharacterEditClose(frm);
				// シナリオ表示を更新
				fncReadSwCharacterList(frm);
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}//end function

// ------------------------------------------------------------------------------
//		登場人物選択
// ------------------------------------------------------------------------------
function fncSelectCharacter(frm,valCharacterId){
	//新規編集エリアがあったら消す
	if($('#edit_new')[0] ){
		//新キャラ登録エリアCLOSE
		fncNewCharacterEditClose(frm);
	}
	//編集エリアがあったらもとに戻す
	if($('#edit_character')[0] ){
		//登場人物編集エリアがあったらもとに戻す
		var EditCharacterId = $('#SelectCharacterId').val();
		fncCharacterEditClose(frm,EditCharacterId);
		//登場人物編集エリア生成
		fncMakeEditCharacter(frm,valCharacterId);
	}else{
		//登場人物編集エリア生成
		fncMakeEditCharacter(frm,valCharacterId);
	}
}
// ------------------------------------------------------------------------------
//		登場人物表示
// ------------------------------------------------------------------------------
function fncSetCharacterById(frm){
	//編集中のキャラクターID
	var EditCharacterId = $('#SelectCharacterId').val();
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditCharacter.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=SetCharacterById",
			success: function(result){
				var tgtID = '#'+'edit_'+EditCharacterId;
				$(tgtID).html(result);
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}
// ------------------------------------------------------------------------------
//		登場人物編集エリア生成
// ------------------------------------------------------------------------------
function fncMakeEditCharacter(frm,valCharacterId){
	//処理ﾓｰﾄﾞをSELECTにする
	$('#SubmitMode').val('SELECT');
	//編集するIDをセット
	$('#SelectCharacterId').val(valCharacterId);
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditCharacter.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=SetCharacterEditForm",
			success: function(result){
				var edit_area = '#'+'edit_'+valCharacterId;
				$(edit_area).html(result);
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}
// ------------------------------------------------------------------------------
//		登場人物更新エリアCLOSE
// ------------------------------------------------------------------------------
function fncCharacterEditClose(frm,valCharacterId){
	//処理ﾓｰﾄﾞをNULLにする
	$('#SubmitMode').val('');
	//編集するIDをセット
	$('#SelectCharacterId').val(valCharacterId);
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEditCharacter.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=CloseCharacterEditForm",
			success: function(result){
				var tgtID = '#'+'edit_'+valCharacterId;
				$(tgtID).html(result);
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}

