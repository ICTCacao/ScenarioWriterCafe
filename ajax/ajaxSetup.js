// ------------------------------------------------------------------------------
//    初期設定画面（swSetup.php）の JS（2026-09）
// ------------------------------------------------------------------------------
function swSetup_collect(){
	return {
		dbType:   $('#dbType').val(),
		dbFile:   $('#dbFile').val(),
		dbHost:   $('#dbHost').val(),
		dbPort:   $('#dbPort').val(),
		dbSocket: $('#dbSocket').val(),
		dbName:   $('#dbName').val(),
		dbUser:   $('#dbUser').val(),
		dbPass:   $('#dbPass').val()
	};
}
//DB種別に応じて入力欄を切り替える（sqlite はファイルのみ、mysql はホスト等）
function swSetupToggleType(){
	var t = $('#dbType').val();
	$('#sqliteFields').toggle(t === 'sqlite');
	$('#mysqlFields').toggle(t !== 'sqlite');
}
function swSetup_msg(ok, text){
	var cls = ok ? 'alert alert-success' : 'alert alert-danger';
	$('#setupMsg').html('<div class="' + cls + '" style="white-space:pre-wrap;">' + $('<div>').text(text).html() + '</div>');
}
function swSetupTest(){
	var d = swSetup_collect(); d.action = 'test';
	$('#setupMsg').html('<div class="text-muted">接続テスト中…</div>');
	$.ajax({ type:'POST', url:'./ajax/ajaxSetup.php', data:d, dataType:'json',
		success:function(r){ swSetup_msg(r.ok, r.message); },
		error:function(){ swSetup_msg(false, '通信エラー'); }
	});
}
function swSetupSave(){
	var d = swSetup_collect(); d.action = 'save';
	$('#setupMsg').html('<div class="text-muted">保存中…</div>');
	$.ajax({ type:'POST', url:'./ajax/ajaxSetup.php', data:d, dataType:'json',
		success:function(r){
			swSetup_msg(r.ok, r.message);
			if (r.ok) { setTimeout(function(){ location.href = './index.php'; }, 800); }
		},
		error:function(){ swSetup_msg(false, '通信エラー'); }
	});
}

function swSetupInstall(){
	var d = swSetup_collect();
	d.action    = 'install';
	d.adminMail = $('#adminMail').val();
	d.adminPass = $('#adminPass').val();
	d.adminPass2= $('#adminPass2').val();
	$('#setupMsg').html('<div class="text-muted">インストール中…（テーブル作成・ユーザー登録）</div>');
	$.ajax({ type:'POST', url:'./ajax/ajaxSetup.php', data:d, dataType:'json',
		success:function(r){
			swSetup_msg(r.ok, r.message);
			if (r.ok) { setTimeout(function(){ location.href = './swUserLogin.html'; }, 1200); }
		},
		error:function(){ swSetup_msg(false, '通信エラー'); }
	});
}
