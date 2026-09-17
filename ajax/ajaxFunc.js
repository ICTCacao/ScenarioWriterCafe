// -----------------------------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//		ScenarioWriterCafe 共通関数
//
//     AjaxFunc.js
// -----------------------------------------------------------------------------
// ----------------------------------------------
// DOUNLOAD MENU JUMP
// ----------------------------------------------
	function AjaxFunc_DounloadMenuJump(frm,jumpTarget,template){
		$('#SubmitMode').val('');
		$('#fdtTemplateId').val(template);

		//別画面(_blank)ではなく非表示 iframe に送る → ファイルは attachment でﾀﾞｳﾝﾛｰﾄﾞされ、画面は遷移しない
		if($('#sw_dl_frame').length == 0){
			$('body').append('<iframe id="sw_dl_frame" name="sw_dl_frame" style="display:none;"></iframe>');
		}
		$(frm).attr('action',jumpTarget);
		$(frm).attr('target','sw_dl_frame');
		$(frm).submit();

		//ﾀﾞｳﾝﾛｰﾄﾞ開始後にｱﾗｰﾄを表示する
		setTimeout(function(){
			bootbox.alert('ダウンロードしました。');
		}, 600);
	}
// ----------------------------------------------
// EDIT MENU JUMP
// ----------------------------------------------
	function AjaxFunc_EditMenuJump(frm,jumpTarget){
		$('#SubmitMode').val('');
		$(frm).attr('action',jumpTarget);
		$(frm).attr('target','_self');
		$(frm).submit();
	}
// ----------------------------------------------
// EDIT MENU JUMP
// ----------------------------------------------
	function AjaxFunc_EditMenuJumpBlank(frm,jumpTarget){
		$('#SubmitMode').val('');

		$(frm).attr('action',jumpTarget);
		$(frm).attr('target','_blank');
		$(frm).submit();

	}
// ----------------------------------------------
//	Datepicker
// ----------------------------------------------
	function AjaxFunc_Datepicker(obj,obj_year,obj_month,obj_day,yy,mm,dd){

		$(function(){
			$(obj).datepicker();
		});
	}
// ----------------------------------------------
// NAVIを表示する
// ----------------------------------------------
	function AjaxFunc_NaviLoad(){
	    $(function($){
	        $phppath = './ajax/ajaxNaviLoad.php';
	        $.ajax({
	            async:false,
	            type: "POST",
	            url: $phppath,
	            success: function(result){
	                $(".sw-navi").html(result);
	            },
	            error:function(result){
	                alert(result);
	            },
	        });
		});
	}
// ----------------------------------------------
// footerを表示する
// ----------------------------------------------
	function AjaxFunc_FooterLoad(){
	    $(function($){
	        $phppath = './include/swFooter.php';
	        $.ajax({
	            async:false,
	            type: "POST",
	            url: $phppath,
	            success: function(result){
	                $(".sw-footer").html(result);
	            },
	            error:function(result){
	                alert(result);
	            },
	        });
		});
	}
// ----------------------------------------------
// ログイン画面を表示する
//	AjaxFunc_SumbitLogin(valMsg)
// ----------------------------------------------
	function AjaxFunc_SumbitLogin(url){

		location.href=url;

	}
// ----------------------------------------------
// ｸﾘｯｸでｸﾘｱする
//	onClickClear(target,valBefore)
// ----------------------------------------------
	function AjaxFunc_ClickClear(target,valBefore) {
		if ( target.value == valBefore ){
			target.value = "";
		}
	}

// ----------------------------------------------
// Enterが押されたときsubmitしない
//	BlockEnter(evt)
// ----------------------------------------------
	function BlockEnter(evt){
		evt = (evt) ? evt : event;
		var charCode=(evt.charCode) ? evt.charCode :
			((evt.which) ? evt.which : evt.keyCode);
		if ( Number(charCode) == 13 || Number(charCode) == 3) {
			return false;
		} else {
			return true;
		}
	}


// --------------------------------------------
// 更新系のﾎﾞﾀﾝが押されたときの制御
//	frmSubmit(frm,valSubmitMode,valMsg)
// --------------------------------------------
	function AjaxFunc_Submit(frm,valSubmitMode,valMsg){
		if (confirm(valMsg + "　実行しますか？")){
			frm.SubmitMode.value = valSubmitMode;
			frm.target = "_self";
			frm.submit();
			return true;
		}
		return false;
	}
// --------------------------------------------
// 更新系のﾎﾞﾀﾝが押されたときの制御
//	AjaxFunc_SubmitNow(frm,valSubmitMode,valMsg)
// --------------------------------------------
	function AjaxFunc_SubmitNow(frm,valSubmitMode){
		frm.SubmitMode.value = valSubmitMode;
		frm.target = "_self";
		frm.submit();
		return true;
	}
// --------------------------------------------
//  ﾎﾞﾀﾝが押されたときの制御
//	AjaxFunc_SubmitNoMsg(frm,valAction)
// --------------------------------------------
	function AjaxFunc_SubmitNoMsg(frm,valAction){
		frm.action = valAction;
		frm.target = "_self";
		frm.submit();
		return true;
	}
// ----------------------------------------------
// Optionの選択値のﾁｪｯｸ
//	frmOptCheck(frm,valElements,valMsg)
// ----------------------------------------------
	function AjaxFunc_OptCheck(frm,valElements,valMsg){
		var flag = 0;
		// 設定開始（チェックする項目を設定してください）
		if(frm.elements[valElements].options[frm.elements[valElements].selectedIndex].value == ""){
			flag = 1;
		}
		if(flag){
			window.alert(valMsg+"を選択してください"); // 選択されていない場合は警告ダイアログを表示
			return false;
		}
		else{
			return true;
		}

	}

// ----------------------------------------------
// Optionの選択値のﾁｪｯｸ
//	frmOptCheckNoMsg(frm,valElements)
// ----------------------------------------------
	function AjaxFunc_OptCheckNoMsg(frm,valElements){
		var flag = 0;
		// 設定開始（チェックする項目を設定してください）
		if(frm.elements[valElements].options[frm.elements[valElements].selectedIndex].value == ""){
			flag = 1;
		}
		if(flag){
			return 0;
		}
		else{
			return 1;
		}

	}
// ----------------------------------------------
// 電話番号必須ﾁｪｯｸで
// 	AjaxFunc_TelCheck(obj)
// ----------------------------------------------
	function AjaxFunc_TelCheck(frm,valElements,valMsg){
		// 変数pObjに格納
		var str=frm.elements[valElements].value;
		var substr=str.replace(/[\-−ー―?‐\(\)（）\s]/g,"");

		if(str ==""){
			alert(valMsg+"は必須項目のため省略できません。");
			return false;
		}else if( str.match( /[^0-9０-９\-−ー―?‐\(\)（）\s]+/ ) ) {
			alert(valMsg+"　数字と-で入力して下さい。");
			return false;
		}else if( substr.match( /^00|^００/ ) ) {
			alert(valMsg+"　番号を確認して下さい。");
			return false;
		}else if(substr.length>11 ) {
			alert(valMsg+"　桁数がオーバーしました。");
			return false;
		}else if( !substr.match( /^0.0|^０.０/ ) && substr.length>10 ) {
			alert(valMsg+"　桁数がオーバーしました。");
			return false;
		}else if( substr.match( /^0.0|^０.０/ ) && substr.length<11 ) {
			alert(valMsg+"　入力が不完全です");
			return false;
		}else if(substr.length<10 ) {
			alert(valMsg+"　入力が不完全です");
			return false;
		}
		return true;
	}
// ----------------------------------------------
// Nullﾁｪｯｸ
//	frmNullCheck(frm,valElements,valMsg)
// ----------------------------------------------
	function AjaxFunc_NullCheck(frm,valElements,valMsg){
		// 変数pObjに格納
		var pData=frm.elements[valElements].value;
		var strMsg = valMsg+"は必須項目のため省略できません。";

	  	if (pData == ''){
		  	bootbox.alert(strMsg, function() {
		  	});
		  	return false;
		}
		return true;
	}
// ----------------------------------------------
// Zeroﾁｪｯｸ
//	frmZeroCheck(frm,valElements,valMsg)
// ----------------------------------------------
	function AjaxFunc_ZeroCheck(frm,valElements,valMsg){
		// 変数pObjに格納
		var pData=frm.elements[valElements].value;
		var strMsg = valMsg+"は必須項目のためゼロでは登録できません。";

	  	if (pData == '0'){
			bootbox.alert(strMsg, function() {
		  	});
			return false;
		}
		return true;
	}
// ----------------------------------------------
// Nullﾁｪｯｸ
//	frmNullCheckNoMsg(frm,valElements)
// ----------------------------------------------
	function AjaxFunc_NullCheckNoMsg(frm,valElements){
		// 変数pObjに格納
		var pData=frm.elements[valElements].value;

	  	if (pData == ''){
			return false;
		}
		return true;
	}
// ----------------------------------------------
// -1 ﾁｪｯｸ
//	frmOptNonSelect(frm,valElements,valMsg)
// ----------------------------------------------
	function AjaxFunc_OptNonSelect(frm,valElements,valMsg){
		// 変数pObjに格納
		var pData=frm.elements[valElements].value;
		var strMsg = valMsg+"は必須項目のため省略できません。";

	  	if (pData == '-1'){
			bootbox.alert(strMsg, function() {
		  	});
			return false;
		}
		return true;
	}
// ----------------------------------------------
// -1 ﾁｪｯｸ
//	frmOptNonSelectNoMsg(frm,valElements)
// ----------------------------------------------
	function AjaxFunc_OptNonSelectNoMsg(frm,valElements){
		// 変数pObjに格納
		var pData=frm.elements[valElements].value;

	  	if (pData == '-1'){
			return 0;
		}
		return 1;
	}
// ----------------------------------------------
// 00 ﾁｪｯｸ
//	frmOptZeroNoMsg(frm,valElements)
// ----------------------------------------------
	function AjaxFunc_OptZeroNoMsg(frm,valElements){
		// 変数pObjに格納
		var pData=frm.elements[valElements].value;

	  	if (pData == '0000'){
			return 0;
		}
	  	if (pData == '00'){
			return 0;
		}
		return 1;
	}
// ----------------------------------------------
// 半角数字ﾁｪｯｸ
//	AjaxFunc_NumberCheck(frm,valElements,valMsg)
// ----------------------------------------------
	function AjaxFunc_NumberCheck(frm,valElements,valMsg) {
		// 変数pObjに格納
		var strNum=frm.elements[valElements].value;
		var num = new String(strNum).replace(/,/g, "");
		var num = new String(num).replace(/-/, "");
		var strMsg = valMsg+"は半角数字のみで入力して下さい。";
		if( num.match( /[^0-9]+/ ) ) {
			bootbox.alert(strMsg, function() {
		  	});
			return false;
		}
		return true;
	}
// ----------------------------------------------
// 半角数字ﾁｪｯｸ
//	NumberCheckNoMsg(frm,valElements)
// ----------------------------------------------
	function AjaxFunc_NumberCheckNoMsg(frm,valElements) {
		// 変数pObjに格納
		var strNum=frm.elements[valElements].value;
		var num = new String(strNum).replace(/,/g, "");
		var num = new String(num).replace(/-/, "");

		if( num.match( /[^0-9]+/ ) ) {
			return false;
		}
		return true;
	}
// ----------------------------------------------
// 文字数ﾁｪｯｸ
//	frmLengthCheck(frm,valElements,valElementsMei,valMaxLength)
// ----------------------------------------------
	function AjaxFunc_LengthCheck(frm,valElements,valElementsMei,valMaxLength){
		var tgt = frm.elements[valElements].value;
		var len = tgt.length;
		var strMsg = valElementsMei+"の入力可能な文字数は"+valMaxLength+"文字までです";
		if(len > valMaxLength){
			bootbox.alert(strMsg, function() {
		  	});
			return false;
		}
		return true;
	}
// ----------------------------------------------
// 桁区切り
//	AjaxFunc_AddFigure(frm,valElements)
// ----------------------------------------------
function AjaxFunc_AddFigure(frm,valElements) {
	// 変数pObjに格納
	var strNum=frm.elements[valElements].value;
	var num = new String(strNum).replace(/,/g, "");
	var num = new String(num).replace(/-/, "");
	var strMsg = "半角数字で入力して下さい。";
	if( num.match( /[^0-9]+/ ) ) {
		bootbox.alert(strMsg, function() {
	  	});
	  	frm.elements[valElements].value='';
		return false;
	}
	// 桁区切りする
	var str = frm.elements[valElements].value;
	var num = new String(str).replace(/,/g, "");
	while(num != (num = num.replace(/^(-?\d+)(\d{3})/, "$1,$2")));
	frm.elements[valElements].value=num;
}
// ----------------------------------------------
// 日付入力ﾁｪｯｸ
//	frmZeroDateCheck(frm,valYear,valMonth,valDay,valMsg)
// ----------------------------------------------
	function AjaxFunc_ZeroDateCheck(frm,valYear,valMonth,valDay,valMsg){
		// 変数pObjに格納
		var pYear=frm.elements[valYear].value;
		var pMonth=frm.elements[valMonth].value;
		var pDay=frm.elements[valDay].value;

  		if ( pYear == '0000'){
			bootbox.alert(valMsg+"の年が入力されていません。", function() {
		  	});
			return false;
		}
  		if ( pMonth == '00'){
			bootbox.alert(valMsg+"の月が入力されていません。", function() {
		  	});
			return false;
		}
  		if ( pDay == '00'){
			bootbox.alert(valMsg+"の日が入力されていません。", function() {
		  	});
			return false;
		}
	  	return true;
	}
// ----------------------------------------------
// 日付入力ﾁｪｯｸ(入力なしをOKにする)
//	frmZeroDateCheck(frm,valYear,valMonth,valDay,valMsg)
// ----------------------------------------------
	function AjaxFunc_CalendarDateCheck(frm,valYear,valMonth,valDay,valMsg){
		// 変数pObjに格納
		var pYear=frm.elements[valYear].value;
		var pMonth=frm.elements[valMonth].value;
		var pDay=frm.elements[valDay].value;

		//入力なしをOKにする
	  	if ((pYear == '0000') && (pMonth == '00') && (pDay == '00')){
	  		return true;
	  	}
  		if ( pYear == '0000'){
			bootbox.alert(valMsg+"の年が入力されていません。", function() {
		  	});
			return false;
		}
  		if ( pMonth == '00'){
			bootbox.alert(valMsg+"の月が入力されていません。", function() {
		  	});
			return false;
		}
  		if ( pDay == '00'){
			bootbox.alert(valMsg+"の日が入力されていません。", function() {
		  	});
			return false;
		}
	  	return true;
	}

// ----------------------------------------------
//  前ゼロ埋め
//	AjaxFunc_PaddingStr(str, length)
// ----------------------------------------------
function AjaxFunc_PaddingStr(str, length){
    while (str.length < length) str = '0' + str;
    return str;
}
// ----------------------------------------------
// 日付（YYYY/MM/DD）ﾁｪｯｸ
// AjaxFunc_CheckDate(strDate)
// ----------------------------------------------
function AjaxFunc_CheckDate(strDate){
    if (strDate.length == 0 || strDate== "") {
        return false;
    }
    var arrDate = strDate.split("/");
    if(arrDate.length == 3) {
        var date = new Date(arrDate[0] , arrDate[1] - 1 ,arrDate[2]);
        if(date.getFullYear() == arrDate[0] &&
          (date.getMonth() == arrDate[1] - 1) &&
           date.getDate() == arrDate[2]) {
            return true;
        }
    }
    return false;
}
// ----------------------------------------------
// 日付ﾁｪｯｸで Dateを返す
// AjaxFunc_CheckReturnDate(strYY,strMM,strDD,msg)
// ----------------------------------------------
function AjaxFunc_CheckReturnDate(strYY,strMM,strDD,msg){
	var strDate = strYY+'/'+strMM+'/'+strDD;

	var AlertMsg = msg+'の日付が入力されていません。';
    if (strDate.length == 0 || strDate== "") {
        bootbox.alert(AlertMsg, function() {
		  	});
        return 0;
    }

    var AlertMsg = msg+'の日付が不正です。';
    var arrDate = strDate.split("/");
    if(arrDate.length == 3) {
        var date = new Date(arrDate[0] , arrDate[1] - 1 ,arrDate[2]);
        if(date.getFullYear() == arrDate[0] &&
          (date.getMonth() == arrDate[1] - 1) &&
           date.getDate() == arrDate[2]) {
            return date;
        }
    }
	bootbox.alert(lertMsg+' '+strDate, function() {
		  	});

    return 0;
}
// ----------------------------------------------
// 日付ﾁｪｯｸで ﾌｫｰﾏｯﾄしたDateを返す
// AjaxFunc_CheckReturnFormatDate(strYY,strMM,strDD,pattern,msg)
// ----------------------------------------------
function AjaxFunc_CheckReturnFormatDate(strYY,strMM,strDD,pattern,msg){
	var strDate = strYY+'/'+strMM+'/'+strDD;

	var AlertMsg = msg+'の日付が不正です。';
    if (strDate.length == 0 || strDate== "") {
        bootbox.alert(AlertMsg, function() {
		  	});
        return 0;
    }
    var arrDate = strDate.split("/");
    if(arrDate.length == 3) {
        var date = new Date(arrDate[0] , arrDate[1] - 1 ,arrDate[2]);
        if(date.getFullYear() == arrDate[0] &&
          (date.getMonth() == arrDate[1] - 1) &&
           date.getDate() == arrDate[2]) {
            return DateFormatter.format(date, pattern);
        }
    }
    bootbox.alert(AlertMsg, function() {
		  	});
    return 0;
}

// ----------------------------------------------
// 電話番号ﾁｪｯｸ(RealTime)
// 	AjaxFunc_TelCheck(obj)
// ----------------------------------------------
function AjaxFunc_TelCheckRealTime(obj){
	var str = obj.value;
	var substr=str.replace(/[\-−ー―?‐\(\)（）\s]/g,"");
	var alertId= "alert_"+obj.id;

	if(str ==""){
		document.getElementById(alertId).innerHTML="";
	}else if( str.match( /[^0-9０-９\-−ー―?‐\(\)（）\s]+/ ) ) {
		document.getElementById(alertId).innerHTML="数字のみで入力して下さい。";
	}else if( substr.match( /^[^0|０]/ ) ) {
		document.getElementById(alertId).innerHTML="市外局番から入力して下さい。";
	}else if( substr.match( /^00|^００/ ) ) {
		document.getElementById(alertId).innerHTML="番号を確認して下さい。";
	}else if(substr.length>11 ) {
		document.getElementById(alertId).innerHTML="桁数がオーバーしました。";
	}else if( !substr.match( /^0.0|^０.０/ ) && substr.length>10 ) {
		document.getElementById(alertId).innerHTML="桁数がオーバーしました。";
	}else if( substr.match( /^0.0|^０.０/ ) && substr.length<11 ) {
		document.getElementById(alertId).innerHTML="入力が不完全です";
	}else if(substr.length<10 ) {
		document.getElementById(alertId).innerHTML="入力が不完全です";
	}else{
		document.getElementById(alertId).innerHTML="";
	}
}

// --------------------------------------------
// メールアドレスかどうかチェックする
//		fncCheckMail(frm,valElements)
// --------------------------------------------
function AjaxFunc_CheckMail(frm,valElements) {
	var mf=frm.elements[valElements].value;

	ml = /.+@.+\..+/; // チェック方式
	if(!mf.match(ml)) {
    	bootbox.alert("メールアドレスが不正です", function() {
		  	});
		return false;
	}
	return true;
}

