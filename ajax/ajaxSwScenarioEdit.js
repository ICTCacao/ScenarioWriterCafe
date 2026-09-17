// ------------------------------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//		
//		ajaxSwScenarioEdit.js
//		
//    	charset=UTF-8
// ------------------------------------------------------------------------------
// ------------------------------------------------------------------------------
//	form 制御
// ------------------------------------------------------------------------------
jQuery(document).ready(function() {
	//selectbox onchange　ｲﾍﾞﾝﾄ
	$('#fdtSceneId').change(function() {
		$("#listpos").text(0);
		//検索状態解除
		$("#SearchMode").val("");
		fncReadScenarioLinesOfScene(frmSwScenario);
	});
    $(function(){
        $("input").keydown(function(e) {
            if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
                return false;
            } else {
                return true;
            }
        });
    });
});

// ------------------------------------------------------------------------------
//		シナリオMOVE BEFORE		一つ前に移動
// ------------------------------------------------------------------------------
function fncMoveScenarioLinesBefore(frm,valId){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		$('#SubmitMode').val('UPDATE');
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEdit.php";
		//ひとつ前にする
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=MoveScenarioLinesBefore&tgtId="+ valId,
			success: function(result){
				// シナリオ表示を更新
				fncMakeScenarioLinesOfScene(frm);
			},
		});
	});// end jQuery(function($)
}
// ------------------------------------------------------------------------------
//		シナリオMOVE AFTER		一つ後に移動
// ------------------------------------------------------------------------------
function fncMoveScenarioLinesAfter(frm,valId){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		$('#SubmitMode').val('UPDATE');
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEdit.php";
		//ひとつ前にする
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=MoveScenarioLinesAfter&tgtId="+ valId,
			success: function(result){
				// シナリオ表示を更新
				fncMakeScenarioLinesOfScene(frm);
			},
		});
	});// end jQuery(function($)
}


// ------------------------------------------------------------------------------
//		シナリオ挿入準備
// ------------------------------------------------------------------------------
function fncScenarioNextLinesInit(frm){
	
	$('#fdtScenarioType').val('1');
	$('#fdtCharacterId').val('-1');
	//$('#fdtScenarioLines').val('');
	
	$('#SubmitMode').val('NEXT');
	//$('#SelectScenarioLinesId').val('');
	
	var EditLinesId = $('#fdtEditLinesId').val();
	var tgtID = '#'+'edit_'+EditLinesId;
	
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEdit.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=GetNextOrderNo",
			success: function(result){
				$('#fdtScenarioLinesOrderNo').val(result);
			},
		});
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=SwitchEditForm",
			success: function(result){
				$(tgtID).html(result);
				fncBindEditFormAutoSave($(tgtID));
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)	
}

// ------------------------------------------------------------------------------
//		シナリオ編集エリアCLOSE
// ------------------------------------------------------------------------------
function fncScenarioEditClose(frm){
	fncSetLinesById(frm);
}
// ------------------------------------------------------------------------------
//		シナリオLINE設定
// ------------------------------------------------------------------------------
function fncSetLinesById(frm){
	var EditLinesId = $('#fdtEditLinesId').val();
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEdit.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=SetLinesById",
			success: function(result){
				var tgtID = '#'+'edit_'+EditLinesId;
				$(tgtID).html(result);
				//行の下に開いた挿入ﾌｫｰﾑ（fncInsertAfterLine）があれば閉じる
				$('.sw-insert-holder').remove();
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}
// ------------------------------------------------------------------------------
//		シナリオ選択
// ------------------------------------------------------------------------------
function fncSelectScenarioLines(frm,valScenarioLineId,valOrderNo){

	var SearchMode = $("#SearchMode").val();
	if(SearchMode == ''){
		if(valOrderNo > 100){
			var target = '#order_'+ (valOrderNo - 100);
			if($(target).length){
				$("html,body").animate({scrollTop:$(target).offset().top});
			}
		}
	}
	//編集エリアがあったらもとに戻す
	if($('#edit_lines')[0] ){
		fncSetLinesById(frm);
		//シナリオ編集エリア生成
		fncMakeEditLines(frm,valScenarioLineId);
	}else{
		//シナリオ編集エリア生成
		fncMakeEditLines(frm,valScenarioLineId);
	}
}
// ------------------------------------------------------------------------------
//		シナリオ編集エリア生成
// ------------------------------------------------------------------------------
function fncMakeEditLines(frm,valScenarioLineId){
	$('#SubmitMode').val('SELECT');
	$('#SelectScenarioLinesId').val(valScenarioLineId);
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEdit.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=SwitchEditForm",
			success: function(result){
				var tgtID = '#'+'edit_'+valScenarioLineId;
				$(tgtID).html(result);
				fncBindEditFormAutoSave($(tgtID));
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}

// ------------------------------------------------------------------------------
//		シナリオ編集領域 jQuery ajax 
// ------------------------------------------------------------------------------
function fncMakeScenarioEditForm(frm){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		$('#SubmitMode').val('SELECT');
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEdit.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=SwitchEditForm",
			success: function(result){
				$("#ScenarioEdit").html(result);
				fncBindEditFormAutoSave($("#ScenarioEdit"));
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
	
}//end function

// ------------------------------------------------------------------------------
//		シナリオ表示 jQuery ajax 
// ------------------------------------------------------------------------------
function fncMakeScenarioLinesOfScene(frm){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		//スクロール位置
		var scpos = $("#listpos").text();

		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEdit.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=ScenarioLinesOfScene",
			success: function(result){
				$("#ScenarioLinesOfScene").html(result);
				fncInitLinesSortable();
			},
			error:function(result){
				alert(result);
			},
		});
		//if ($('#retResult').val() == 'NO_SCENARIO') {
			fncMakeScenarioEditForm(frm);
			//スクロール位置を復元
			$("#ScenelioLines").scrollTop(scpos);
		//}//end if
	});// end jQuery(function($)
	
}//end function

// ------------------------------------------------------------------------------
//		シナリオ表示 jQuery ajax 
// ------------------------------------------------------------------------------
function fncReadScenarioLinesOfScene(frm){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		//検索状態解除
		$("#SearchMode").val("");
		$("#fdtSearchWord").val("");
		//スクロール位置を取得
		var scpos = $("#listpos").text();
		
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEdit.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=ReadScenarioLinesOfScene",
			success: function(result){
				$("#ScenarioLinesOfScene").html(result);
				fncInitLinesSortable();
			},
			error:function(result){
				alert(result);
			},
		});
		//スクロール位置を復元
		$("#ScenelioLines").scrollTop(scpos);
	});// end jQuery(function($)
	
}//end function
// ------------------------------------------------------------------------------
//		シナリオ更新 jQuery ajax 
// ------------------------------------------------------------------------------
function fncScenarioLinesSubmit(frm,valSubmitMode){
	var SceneId = $('#fdtSceneId').val();
	var ScenarioType = $('#fdtScenarioType').val();
	var CharacterId = $('#fdtCharacterId').val();
	var SearchMode = $("#SearchMode").val();
	
	if(SceneId <= '0'){
			//ﾀﾞｲｱﾛｸﾞを表示する
			bootbox.dialog({
				message: "場面が登録されていません。最初に場面設定から場面を登録してください。",
				title: "ScenarioWriterCafe",
				buttons: {
					success: {
						label: "戻る",
						className: "btn-success",
						callback: function() {
							return;
						}
					}
				}
			})
			return;
	}
	if(ScenarioType == '1'){
		if(CharacterId == '-1'){
			//ﾀﾞｲｱﾛｸﾞを表示する
			bootbox.dialog({
				message: "台詞が選択されていますが、登場人物が選択されていません。",
				title: "ScenarioWriterCafe",
				buttons: {
					success: {
						label: "戻る",
						className: "btn-success",
						callback: function() {
							return;
						}
					}
				}
			})
			return;
		}
	}
	
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		//スクロール位置
		var scpos = $("#listpos").text();
		//SubmitFMode設定
		$('#SubmitMode').val(valSubmitMode);
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEdit.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=SwitchEditForm",
			success: function(result){
				//$("#ScenarioEdit").html(result);
				//検索中は再読み込みしない
				if(SearchMode == ''){
					// シナリオ表示を更新
					fncMakeScenarioLinesOfScene(frm);
				}else{
					//編集エリア解除
					fncScenarioEditClose(frm);
				}
				
				if(valSubmitMode == 'INSERT'){
					//続けて編集状態にする
					fncMakeEditLines(frm,result);
					//NEXT
					//fncScenarioNextLinesInit(frm);
				}
			},
			error:function(result){
				alert(result);
			},
		});
		//スクロール位置を復元
		$("#ScenelioLines").scrollTop(scpos);
	});// end jQuery(function($)
}//end function

// ------------------------------------------------------------------------------
//		シナリオ検索 jQuery ajax 
// ------------------------------------------------------------------------------
function fncSearchScenario(frm){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		$("#SearchMode").val('ON');
		$('#SubmitMode').val('');
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEdit.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=Search",
			success: function(result){
				$("#ScenarioLinesOfScene").html(result);
				fncInitLinesSortable();
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}
// ------------------------------------------------------------------------------
//		シナリオ置換 jQuery ajax 
// ------------------------------------------------------------------------------
function fncReplaceScenario(frm){
	jQuery(function($){
		// HTMLでの送信をキャンセル 
		if (window.event) { window.event.preventDefault(); }   // jQuery3 では ready が非同期実行になり window.event が無いことがある
		// 操作対象のフォーム要素を取得
		var $form = $(frm);
		$phppath = "./ajax/ajaxSwScenarioEdit.php";
		$.ajax({
			async:false,
			type: "POST",
			url: $phppath,
			data: $form.serialize()
				+ "&SubMode=Replace",
			success: function(result){
				$("#ScenarioLinesOfScene").html(result);
				$("#listpos").text(0);
				$("#fdtSearchWord").val("");
				$("#SearchMode").val("");
				fncReadScenarioLinesOfScene(frmSwScenario);
			},
			error:function(result){
				alert(result);
			},
		});
	});// end jQuery(function($)
}
// ------------------------------------------------------------------------------
//		本文ｲﾝﾗｲﾝ編集（2026-09 追加）
//		一覧の本文をｸﾘｯｸ → その場で textarea に切り替え（高さ = 表示ﾌﾞﾛｯｸ + 3行）
//		textarea から離れたら自動保存（変更が無ければそのまま戻す）。Esc は取消、Ctrl+Enter は確定。
//		種別・登場人物を変えたいときは従来どおり登場人物名をｸﾘｯｸして編集ﾌｫｰﾑを使う
// ------------------------------------------------------------------------------
function fncInlineEditLines(span, valLinesId){
	var $span = $(span);
	if ($span.data('editing')) { return; }
	$span.data('editing', true);

	var frm = document.frmSwScenario;
	var text = '';
	$.ajax({
		async: false,
		type: "POST",
		url: "./ajax/ajaxSwScenarioEdit.php",
		data: $(frm).serialize() + "&SubMode=GetLinesText&fdtEditLinesId=" + encodeURIComponent(valLinesId),
		success: function(result){ text = result; },
		error: function(){ alert('本文の取得に失敗しました'); }
	});

	//表示ﾌﾞﾛｯｸの高さ + 3行分
	var cs = window.getComputedStyle(span);
	var lineH = parseFloat(cs.lineHeight);
	if (isNaN(lineH)) { lineH = parseFloat(cs.fontSize) * 1.5; }
	var height = $span.height() + lineH * 3 + 12;

	var origHtml = $span.html();
	var $ta = $('<textarea class="form-control sw-inline-textarea"></textarea>').val(text).css('height', height + 'px');
	$span.empty().append($ta);
	$ta.focus();

	var finished = false;
	function restore(){
		if (finished) { return; }
		finished = true;
		$span.html(origHtml);
		$span.data('editing', false);
	}
	function save(){
		if (finished) { return; }
		if ($ta.val() === text) { restore(); return; }   //変更なし
		finished = true;
		var ok = false;
		$.ajax({
			async: false,
			type: "POST",
			url: "./ajax/ajaxSwScenarioEdit.php",
			data: $(frm).serialize() + "&SubMode=InlineUpdate&fdtEditLinesId=" + encodeURIComponent(valLinesId)
				+ "&fdtInlineText=" + encodeURIComponent($ta.val()),
			success: function(result){ ok = ($.trim(result) == 'OK'); },
			error: function(){ ok = false; }
		});
		if(!ok){ alert('保存に失敗しました'); finished = false; return; }
		$span.data('editing', false);
		//一覧を描き直す（ｽｸﾛｰﾙ位置は既存の仕組みで復元）
		$("#listpos").text($("#ScenelioLines").scrollTop());
		if ($("#SearchMode").val() == '') {
			fncMakeScenarioLinesOfScene(frm);
		} else {
			fncSearchScenario(frm);
		}
	}
	$ta.on('click', function(e){ e.stopPropagation(); });
	$ta.on('blur', function(){ save(); });          //離れたら自動保存
	$ta.on('keydown', function(e){
		if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') { e.preventDefault(); $ta.off('blur'); save(); }
		if (e.key === 'Escape') { e.preventDefault(); $ta.off('blur'); restore(); }
	});
}


// ------------------------------------------------------------------------------
//		行の下の追加ﾊﾞｰから「この下に台詞を追加」（2026-09 追加。編集ﾌｫｰﾑの「後に挿入」を置き換え）
//		行(valLinesId, 並び順 valOrderNo)の直後に空の挿入ﾌｫｰﾑを開く。保存すると一覧が描き直される
// ------------------------------------------------------------------------------
function fncInsertAfterLine(valLinesId, valOrderNo){
	var frm = document.frmSwScenario;
	if ($("#SearchMode").val() != '') { return; }   //検索結果の表示中は挿入しない
	//開いている編集/挿入ﾌｫｰﾑを閉じる
	if ($('#edit_lines')[0]) { fncSetLinesById(frm); }
	$('.sw-insert-holder').remove();

	var $form = $(frm);
	var url = "./ajax/ajaxSwScenarioEdit.php";
	var base = $form.serialize() + "&SelectScenarioLinesId=" + encodeURIComponent(valLinesId)
		+ "&fdtEditLinesId=" + encodeURIComponent(valLinesId);
	//挿入する並び順（この行と次の行の間）
	var newOrderNo = '';
	$.ajax({
		async: false, type: "POST", url: url,
		data: base + "&SubMode=GetNextOrderNo&fdtScenarioLinesOrderNo=" + encodeURIComponent(valOrderNo),
		success: function(result){ newOrderNo = $.trim(result); }
	});
	//空の挿入ﾌｫｰﾑを開く（従来の「後に挿入」と同じく、この行の枠 #edit_ID の中に「行の表示 + 空ﾌｫｰﾑ」を描く。
	//  CLOSE(fncSetLinesById) や保存後の一覧再描画で元に戻る）
	$('#SubmitMode').val('NEXT');
	var $row = $('#edit_' + valLinesId);
	$.ajax({
		async: false, type: "POST", url: url,
		data: base + "&SubMode=SwitchEditForm&SubmitMode=NEXT&fdtScenarioType=1&fdtCharacterId=-1"
			+ "&fdtScenarioLinesOrderNo=" + encodeURIComponent(newOrderNo),
		success: function(result){ $row.html(result); fncBindEditFormAutoSave($row); },
		error: function(){ alert('挿入ﾌｫｰﾑを開けませんでした'); }
	});
	var $ta = $row.find('#edit_lines textarea').first();
	if ($ta.length) { $ta.focus(); }
}


// ------------------------------------------------------------------------------
//		ﾄﾞﾗｯｸﾞ&ﾄﾞﾛｯﾌﾟで並び替え（2026-09 追加。jQuery UI Sortable）
//		行左端の ⋮⋮ をつかんで上下に動かす。離すと ReorderLines で並び順を保存し、一覧を描き直す。
//		上下矢印はそのまま使える。検索結果の表示中は無効。
// ------------------------------------------------------------------------------
function fncInitLinesSortable(){
	var $c = $('#ScenelioLines');
	if (!$c.length || !$.fn.sortable) { return; }
	if ($("#SearchMode").val() != '') { return; }
	if ($c.data('ui-sortable')) { $c.sortable('destroy'); }
	$c.sortable({
		items: '> .eidt-lines',
		handle: '.sw-drag-handle',
		axis: 'y',
		tolerance: 'pointer',
		placeholder: 'sw-drop-placeholder',
		forcePlaceholderSize: true,
		scroll: true,
		cursor: 'grabbing',
		update: function(){
			var ids = $c.children('.eidt-lines').map(function(){ return this.id.replace('edit_',''); }).get();
			fncReorderLines(ids);
		}
	});
}
function fncReorderLines(ids){
	var frm = document.frmSwScenario;
	var ok = false;
	$.ajax({
		async: false, type: "POST",
		url: "./ajax/ajaxSwScenarioEdit.php",
		data: $(frm).serialize() + "&SubMode=ReorderLines&lineIds=" + encodeURIComponent(ids.join(',')),
		success: function(result){ ok = ($.trim(result) == 'OK'); },
		error: function(){ ok = false; }
	});
	if(!ok){ alert('並び順の保存に失敗しました'); }
	//並び順番号（order_ ｱﾝｶｰ・追加ﾊﾞｰの値）を揃えるため描き直す。ｽｸﾛｰﾙ位置は復元
	$("#listpos").text($("#ScenelioLines").scrollTop());
	fncMakeScenarioLinesOfScene(frm);
}


// ------------------------------------------------------------------------------
//		台詞編集ﾌｫｰﾑの自動保存（2026-09 追加）
//		ﾌｫｰﾑ(#edit_lines)の外へﾌｫｰｶｽが移ったとき、本文が空でなく変更されていれば
//		保存ﾎﾞﾀﾝと同じ処理（INSERT / UPDATE）を実行する。保存ﾎﾞﾀﾝはそのまま使える。
// ------------------------------------------------------------------------------
function fncBindEditFormAutoSave($container){
	var $box = $container.find('#edit_lines').first();
	if (!$box.length) { $box = $container.filter('#edit_lines'); }
	if (!$box.length) { return; }
	var $ta = $box.find('textarea#fdtScenarioLines').first();
	if (!$ta.length) { return; }
	var onclick = $box.find('input[type=button]').filter(function(){ return $(this).val().replace(/\s/g,'') == '保存'; }).attr('onclick') || '';
	var m = onclick.match(/'(INSERT|UPDATE)'/);
	if (!m) { return; }
	var submitMode = m[1];
	var initial = $.trim($ta.val());
	var done = false;
	$box.off('focusout.swauto').on('focusout.swauto', function(e){
		if (done) { return; }
		var to = e.relatedTarget;
		if (to && $box[0].contains(to)) { return; }        //ﾌｫｰﾑ内の移動
		setTimeout(function(){
			if (done) { return; }
			if (document.activeElement && $box[0].contains(document.activeElement)) { return; }
			if (!document.body.contains($box[0])) { return; }   //既に閉じられた
			var v = $.trim($ta.val());
			if (v === '' || v === initial) { return; }       //空、または変更なし
			//保存ﾎﾞﾀﾝと同じ検証（場面なし / ｾﾘﾌなのに登場人物が未選択）はそのまま働き、ﾀﾞｲｱﾛｸﾞが出る
			done = true;
			fncScenarioLinesSubmit(document.frmSwScenario, submitMode);
			//保存されずﾌｫｰﾑが残っていれば、次の機会にまた試す
			if (document.body.contains($box[0])) { done = false; }
		}, 0);
	});
}
