// ------------------------------------------------------------------------------
//    劇団員プレビューの公開設定（シナリオ情報画面）2026-09
//        ajaxSwPreview.js
// ------------------------------------------------------------------------------
function swPreview_call(subMode){
	var d = {
		SubMode: subMode,
		fdtUserLoginId: $('#fdtUserLoginId').val(),
		fdtUserLoginDate: $('#fdtUserLoginDate').val(),
		fdtScenarioId: $('#fdtScenarioId').val()
	};
	$.ajax({ type:'POST', url:'./ajax/ajaxSwPreview.php', data:d, dataType:'json',
		success:function(r){ swPreview_show(r); },
		error:function(){ swPreview_show({ok:false, valid:0, url:'', message:'通信エラー'}); }
	});
}
function swPreview_show(r){
	if (r.valid == 1) {
		$('#pvStatus').html('<span class="badge bg-success">公開中</span>');
		$('#pvUrl').val(r.url);
		$('#pvOpen').attr('href', r.url);
		$('#pvOnRow').show(); $('#pvBtnEnable').hide(); $('#pvBtnDisable, #pvBtnRegen').show();
	} else {
		$('#pvStatus').html('<span class="badge bg-secondary">非公開</span>');
		$('#pvUrl').val('');
		$('#pvOnRow').hide(); $('#pvBtnEnable').show(); $('#pvBtnDisable, #pvBtnRegen').hide();
	}
	$('#pvMsg').text(r.message || '').toggleClass('text-danger', !r.ok);
}
function swPreview_copy(){
	var v = $('#pvUrl').val(); if (!v) { return; }
	var done = function(){ $('#pvMsg').removeClass('text-danger').text('URL をコピーしました。'); };
	if (navigator.clipboard && navigator.clipboard.writeText) { navigator.clipboard.writeText(v).then(done, function(){ $('#pvUrl').select(); document.execCommand('copy'); done(); }); }
	else { $('#pvUrl').select(); document.execCommand('copy'); done(); }
}
function swPreview_regen(){
	if (!confirm('URL を作り直すと、以前の URL は開けなくなります。よろしいですか？')) { return; }
	swPreview_call('Regenerate');
}
function swPreview_disable(){
	if (!confirm('公開を停止します。劇団員は URL を開けなくなります。よろしいですか？')) { return; }
	swPreview_call('Disable');
}
jQuery(document).ready(function(){ if ($('#pvStatus').length) { swPreview_call('Status'); } });
