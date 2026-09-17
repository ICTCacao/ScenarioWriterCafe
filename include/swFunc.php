<?php
// ------------------------------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//          共通関数
//
//          swFunc.php
//
// ------------------------------------------------------------------------------
// ------------------------------------------------------------------------------
//			swFunc_SubstrR($str,$getLen)
// ------------------------------------------------------------------------------
function swFunc_SubstrR($str,$getLen){
	//文字数
	$strLen = mb_strlen($str);
	$stPos = $strLen - $getLen;
	$retStr = mb_substr($str,$stPos,$getLen,'UTF-8');
	return	$retStr;
}
// ------------------------------------------------------------------------------
// 	台詞の最後の読点を削除
//			swFunc_RemoveMaru($ScenarioLines)
//				$ScenarioLines 文章
// ------------------------------------------------------------------------------
function swFunc_RemoveLastStr($str,$RemoveStr){
	//文字数
	$strLen = mb_strlen($str);
	if( mb_substr($str,$strLen - 1,1,'UTF-8')==$RemoveStr){
		$cstr = mb_substr($str,0,$strLen - 1,'UTF-8');
	}else{
		$cstr = $str;
	}
	return	$cstr;
}

// ------------------------------------------------------------------------------
// 	マルチバイト文字列を禁則処理を加えて指定文字数で区切り配列として返す。
//			swFunc_JpHyphenation($ScenarioLines , $BlkLength)
//				$ScenarioLines 全角変換された文章
//				$BlkLength 一行の文字数
// ------------------------------------------------------------------------------
function swFunc_JpHyphenation($ScenarioLines , $BlkLength){
	// 禁則パターン設定 ------------------------------------------------
	$patternArray = array();
	//行末禁則文字
	array_push ($patternArray,'｛〔〈《「『【〘〖〝｟—…‥〴〵');
	//行頭禁則文字
	array_push ($patternArray,'、〕〉》」』】〙〗〟｠ゝゞ々ーァィゥェォッャュョヮヵヶぁぃぅぇぉっゃゅょゎゕゖㇰㇱㇲㇳㇴㇵㇶㇷㇸㇹㇷ゚ㇺㇻㇼㇽㇾㇿ々〻〜～‼⁇⁈⁉・。');
	// ----------------------------------------------------------------
	//文字列のポジション(ポジションは0から始まる)
	$BlkPos = $BlkLength - 1;
	//改行で分割する
	$ScenarioLinesArray = explode("@@",$ScenarioLines);
	//リターン配列
	$retArray = array();
	//配列ごとに禁則処理して配列化する
	foreach ((array)$ScenarioLinesArray as $ScenarioLinesStr){
			//文字数で判定
			$strLen = mb_strlen($ScenarioLinesStr);
			//指定文字数以下ならそのまま出力する
			if($strLen <= $BlkLength){
				array_push ($retArray,$ScenarioLinesStr);
				continue;
			}
			//禁則処理する
			//$ScenarioLinesStrが空白になるまで繰り返す
			while(mb_strlen($ScenarioLinesStr) > 0 ){
				//指定文字数の次の文字が次行頭禁則文字なら ぶら下がり処理 する
				//指定文字数の次の文字($BlkPos + 1)
				$str = mb_substr($ScenarioLinesStr,$BlkPos+ 1,1,'UTF-8');
				$pattern = $patternArray[1];
				if($str != ''){
					//指定文字数の次の文字が次行頭禁則文字の場合
					if( strpos($pattern,$str)!==false ){
						//残りが1文字のときは強制的にぶら下がり処理する
						if( mb_strlen(mb_substr($ScenarioLinesStr,$BlkPos + 2,mb_strlen($ScenarioLinesStr),'UTF-8')) == 1){
							array_push ($retArray,$ScenarioLinesStr);
							//指定文字数の次の文字($BlkPos + 3)から最後まで
							$ScenarioLinesStr = '';
							continue;
						}
						//先頭[0]から指定文字数の次の文字($BlkLength + 1)まで出力
						$myStr = mb_substr($ScenarioLinesStr,0,$BlkLength + 1,'UTF-8');
						array_push ($retArray,$myStr);
						//指定文字数の次の文字($BlkPos + 2)から最後まで
						$ScenarioLinesStr = mb_substr($ScenarioLinesStr,$BlkPos + 2,mb_strlen($ScenarioLinesStr),'UTF-8');
						continue;
					}
				}
				//行末禁則文字を検索
				//指定文字数($BlkPos)の文字
				$str = mb_substr($ScenarioLinesStr,$BlkPos,1,'UTF-8');
				$pattern = $patternArray[0];
				//指定文字数($BlkPos)の文字が行末禁則文字の場合
				if($str != ''){
					if( strpos($pattern,$str)!==false ){
						//先頭[0]から指定文字数の前の文字($BlkLength - 1)まで出力
						$myStr = mb_substr($ScenarioLinesStr,0,$BlkLength - 1,'UTF-8');
						array_push ($retArray,$myStr);
						//指定文字数から最後まで
						$ScenarioLinesStr = mb_substr($ScenarioLinesStr,$BlkPos - 1,mb_strlen($ScenarioLinesStr),'UTF-8');
						continue;
					}
				}
				//指定文字まで出力
				$myStr = mb_substr($ScenarioLinesStr,0,$BlkLength,'UTF-8');
				array_push ($retArray,$myStr);
				//指定文字数の次の文字から最後まで
				$ScenarioLinesStr = mb_substr($ScenarioLinesStr,$BlkPos + 1,mb_strlen($ScenarioLinesStr),'UTF-8');
			}//end while
	}//end foreach

	return	$retArray;
}
// ------------------------------------------------------------------------------
// シナリオのオプション反映
// $OptionStyleArray = swFunc_MakeOptionStyleCss($mySqlConnObj,$clsSwUserOption,$UserOptionId,$Str,$StrLine)
// ------------------------------------------------------------------------------
function swFunc_MakeOptionStyleCss($mySqlConnObj,$clsSwUserOption,$UserOptionId,$Str,$StrLine){

	$OptionStyleArray = array();
	//ﾃﾞｰﾀ管理ｸﾗｽの初期化
	$clsSwUserOption->clsSwUserOptionInit($mySqlConnObj,$UserOptionId);
	//プロパティGET
	$fdtUserOptionStyleFontSize = $clsSwUserOption->clsSwUserOptionGetUserOptionStyleFontSize();//フォントサイズ
	$fdtUserOptionStyleColor = $clsSwUserOption->clsSwUserOptionGetUserOptionStyleColor();//文字色
	$fdtUserOptionStyleIndent = $clsSwUserOption->clsSwUserOptionGetUserOptionStyleIndent();//字下げ数
	$fdtUserOptionStyleStr = $clsSwUserOption->clsSwUserOptionGetUserOptionStyleStr();//省略文字
	$fdtUserOptionStyleWord = $clsSwUserOption->clsSwUserOptionGetUserOptionStyleWord();//台詞

	switch($fdtUserOptionStyleWord){
		case '1'://登場人物名表示&台詞を「」で囲む
				$Str = $Str.'&nbsp;'.$fdtUserOptionStyleStr;
				$StrLine = ''.$StrLine.'';
				$align = 'left';
			break;
		case '2'://登場人物名表示&台詞を「」で囲まない
				$Str = $Str.'&nbsp;'.$fdtUserOptionStyleStr;
				$align = 'left';
			break;
		case '3'://登場人物名非表示&台詞を「」で囲む
				$Str = $fdtUserOptionStyleStr;
				$StrLine = ''.$StrLine.'';
				$align = 'right';
			break;
		default://登場人物名非表示&台詞を「」で囲まない
				$Str = $fdtUserOptionStyleStr;
				$align = 'right';
			break;
	}
	//CSS編集
	$cssStr = 'style="font-size: '.$fdtUserOptionStyleFontSize.'pt;text-align: '.$align.';"';
	$cssStrLine = 'style="font-size: '.$fdtUserOptionStyleFontSize.'pt;color: '.$fdtUserOptionStyleColor.';padding-left: '.$fdtUserOptionStyleIndent.'em;"';


	array_push($OptionStyleArray,$cssStr);
	array_push($OptionStyleArray,$Str);
	array_push($OptionStyleArray,$cssStrLine);
	array_push($OptionStyleArray,$StrLine);

	return	$OptionStyleArray;
}
// ------------------------------------------------------------------------------
// CSVﾃﾞｰﾀ ScenarioType
// $csvArray = swFunc_MakeSelectItemsCsvScenarioType($mySqlConnObj,$UserId)
// ------------------------------------------------------------------------------
function swFunc_MakeSelectItemsCsvScenarioType($mySqlConnObj,$valUserId){
	//スタイルを取得
	$strSQL = <<<END_OF_SQL

		SELECT CONCAT(USER_OPTION_STYLE_ID,':',USER_OPTION_STYLE_NAME)	AS	CSVITEM
			FROM SW_USER_OPTION
				WHERE USER_ID = '$valUserId'
				ORDER BY USER_OPTION_STYLE_ORDER_NO;
END_OF_SQL;
	$stmt = $mySqlConnObj->prepare($strSQL);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	//パラメータのセット
	$stmt->execute();
	//件数取得
	$myRowCnt = $stmt->rowCount();
	//登録がなければデフォルト
	if( $myRowCnt == '0'){
		$csvArray = array();
		array_push($csvArray,"1:セリフ");
		array_push($csvArray,"2:ト書");
		array_push($csvArray,"3:歌詞");
		array_push($csvArray,"4:ナレーション");
		array_push($csvArray,"5:モノローグ");
		array_push($csvArray,"6:テロップ");
		array_push($csvArray,"7:演技指示");
		array_push($csvArray,"8:音響指示");
		array_push($csvArray,"9:照明指示");
		return	$csvArray;
	}else{
		// SQL を実行して CSV 配列を返す (-1:---　を表示)
		return swFunc_ResultToCsvArray($mySqlConnObj,$strSQL,FALSE,'');
	}
}

// ------------------------------------------------------------------------------
// 文字コード CharacterCode
// $csvArray = swFunc_MakeSelectItemsCsvCharacterCode()
// ------------------------------------------------------------------------------
function swFunc_MakeSelectItemsCsvCharacterCode(){
	$csvArray = array();
	array_push($csvArray,"UTF-8:UTF-8");
	array_push($csvArray,"EUC-JP:EUC-JP");
	array_push($csvArray,"SJIS:SJIS");
	array_push($csvArray,"eucjp-win:eucjp-win");
	array_push($csvArray,"SJIS-win:SJIS-win");

	return	$csvArray;
}
// ------------------------------------------------------------------------------
// 改行コード LineFeedCode
// $csvArray = swFunc_MakeSelectItemsCsvLineFeedCode()
// ------------------------------------------------------------------------------
function swFunc_MakeSelectItemsCsvLineFeedCode(){
	$csvArray = array();
	array_push($csvArray,"LF:LF");
	array_push($csvArray,"CR:CR");
	array_push($csvArray,"CRLF:CR+LF");

	return	$csvArray;
}

// ------------------------------------------------------------------------------
// CSVﾃﾞｰﾀ LineType
// $csvArray = swFunc_MakeSelectItemsCsvLineType()
// ------------------------------------------------------------------------------
function swFunc_MakeSelectItemsCsvLineType(){
	$csvArray = array();
	array_push($csvArray,"1:登場人物名表示&台詞を「」で囲む");
	array_push($csvArray,"2:登場人物名表示&台詞を「」で囲まない");
	array_push($csvArray,"3:登場人物名非表示&台詞を「」で囲む");
	array_push($csvArray,"0:登場人物名非表示&台詞を「」で囲まない");

	return	$csvArray;
}

// ------------------------------------------------------------------------------
// CSVﾃﾞｰﾀ ScenarioCategory
// $csvArray = swFunc_MakeSelectItemsCsvScenarioCategory()
// ------------------------------------------------------------------------------
function swFunc_MakeSelectItemsCsvScenarioCategory(){
	$csvArray = array();
	array_push($csvArray,"0:---");
	array_push($csvArray,"1:演劇");
	array_push($csvArray,"2:ミュージカル");
	array_push($csvArray,"3:高校演劇");
	array_push($csvArray,"4:大衆演劇");
	array_push($csvArray,"5:映画");
	array_push($csvArray,"6:テレビドラマ");
	array_push($csvArray,"7:テレビ番組");
	array_push($csvArray,"8:ラジオドラマ");
	array_push($csvArray,"9:ラジオ番組");
	array_push($csvArray,"10:その他");

	return	$csvArray;
}

// ------------------------------------------------------------------------------
// CSVﾃﾞｰﾀ AdminClass
// $csvArray = swFunc_MakeSelectItemsCsvAdminClass()
// ------------------------------------------------------------------------------
function swFunc_MakeSelectItemsCsvAdminClass(){
	$csvArray = array();
	array_push($csvArray,"0:一般管理者");
	array_push($csvArray,"1:システム管理者");

	return	$csvArray;
}
//------------------------------------------------------------------------------
//	$NewPassword = swFunc_MakePassword()
//	仮のパスワード生成
// ------------------------------------------------------------------------------
function swFunc_MakeNewPassword(){
	//仮のﾊﾟｽﾜｰﾄﾞ文字列設定
	return substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
}
// ------------------------------------------------------------------------------
//	swFunc_Hash($str,$pwd)
//	ハッシュ化
// ------------------------------------------------------------------------------
function swFunc_Hash($str,$pwd){
	//$strをhash256でハッシュ化
	$hash = hash('sha256', $str);

	//ハッシュ化した文字列に、$pwdを追加する
	$hash = $pwd.$hash.$pwd;

	//再度hash256でハッシュ化
	$hash = hash('sha256', $hash);

	return	$hash;
}
// ------------------------------------------------------------------------------
//	swFunc_MakeRandStr($length)
//	ランダム文字列生成 (英数字)
// ------------------------------------------------------------------------------
function swFunc_MakeRandStr($length) {
	$str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
	$retStr = '';
	for ($i = 0; $i < $length; $i++) {
		$retStr .= $str[rand(0, count($str)-1)];
	}
	return $retStr;
}
// ------------------------------------------------------------------------------
//	swFunc_SanitizeStrings
//	ｻﾆﾀｲｽﾞ
// ------------------------------------------------------------------------------
function swFunc_SanitizeStrings($str){

	$SanitizeStr = htmlspecialchars((string)$str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');   //PHP8.1: null を渡すと Deprecated
	return	$SanitizeStr;
}
// ------------------------------------------------------------------------------
//	swFunc_BaseUrl()
//	このサイトのルート URL（設置先に依存しないよう、今のリクエストから組み立てる）
//	例: https://example.com/scw/   ajax/ から呼ばれたら 1 つ上のディレクトリ
//	メール本文の URL や共有 URL に使う。_ROOT_URL_（固定値）は使わない。
// ------------------------------------------------------------------------------
function swFunc_BaseUrl(){
	$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
		|| (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
	$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
	$dir = str_replace('\\', '/', dirname(isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '/'));
	if (substr($dir, -5) === '/ajax') { $dir = substr($dir, 0, -5); }
	$dir = rtrim($dir, '/');
	return ($https ? 'https' : 'http') . '://' . $host . $dir . '/';
}
// ------------------------------------------------------------------------------
//	swFunc_GetPostData($index)
//	POSTﾃﾞｰﾀから内容を取得
// ------------------------------------------------------------------------------
function swFunc_GetPostData($index){
	$postData = '';
	if (isset($_POST[$index])) {
		//ｻﾆﾀｲｽﾞは，HTML出力時にhtmlspecialchars化する
		$postData = $_POST[$index];
	}else{
		$postData = '';
	}
	return	$postData;
}
// ------------------------------------------------------------------------------
//	swFunc_GetSessionData($index)
//	POSTﾃﾞｰﾀから内容を取得
// ------------------------------------------------------------------------------
function swFunc_GetSessionData($index){
	$sessionData = '';
	if (isset($_SESSION[$index])) {
		$sessionData = $_SESSION[$index];
	}else{
		$sessionData = '';
	}
	return	$sessionData;
}

// ------------------------------------------------------------------------------
// YES/NOのCSVﾃﾞｰﾀ を 取得する
//		$csvArray = swFunc_MakeYesNoCsv()
// ------------------------------------------------------------------------------
function swFunc_MakeYesNoCsv(){
	$csvArray = array();
	array_push($csvArray,"0:はい");
	array_push($csvArray,"1:いいえ");
	return	$csvArray;
}

// ------------------------------------------------------------------------------
// YES/NOのCSVﾃﾞｰﾀ を 取得する
//		$csvArray = swFunc_MakeYesNoCsv()
// ------------------------------------------------------------------------------
function swFunc_MakeSelectItemsCsvSceneValidCd(){

	$csvArray = array();
	array_push($csvArray,"0:有効");
	array_push($csvArray,"9:無効");
	return	$csvArray;
}
//--------------------------------------------------------------------------------
//	場面選択のCSVﾃﾞｰﾀ を 取得する
//		$csvArray = swFunc_MakeSelectItemsCsvSceneId($mySqlConnObj,$fdtScenarioId)
//--------------------------------------------------------------------------------
function swFunc_MakeSelectItemsCsvSceneId($mySqlConnObj,$fdtScenarioId){
	$strSQL = <<<END_OF_SQL

		SELECT CONCAT(SCENE_ID,':',SCENE_NAME)	AS	CSVITEM
			FROM SW_SCENE
			WHERE SCENARIO_ID = '$fdtScenarioId'
			  AND SCENE_VALID_CD = '0'
			ORDER BY SCENE_ORDER_NO;
END_OF_SQL;

	// SQL を実行して CSV 配列を返す (-1:---　を表示)
	return swFunc_ResultToCsvArray($mySqlConnObj,$strSQL,FALSE,'');

}
//--------------------------------------------------------------------------------
//	登場人物選択のCSVﾃﾞｰﾀ を 取得する
//		$csvArray = swFunc_MakeSelectItemsCsvSceneId($mySqlConnObj,$fdtScenarioId)
//--------------------------------------------------------------------------------
function swFunc_MakeSelectItemsCsvCharacterId($mySqlConnObj,$fdtScenarioId){
	$strSQL = <<<END_OF_SQL

		SELECT CONCAT(CHARACTER_ID,':',CHARACTER_NAME)		AS	CSVITEM
			FROM SW_CHARACTER
			WHERE SCENARIO_ID = '$fdtScenarioId'
			ORDER BY CHARACTER_ORDER_NO;
END_OF_SQL;

	// SQL を実行して CSV 配列を返す (-1:---　を表示)
	return swFunc_ResultToCsvArray($mySqlConnObj,$strSQL,TRUE,'');

}

//--------------------------------------------------------------------------------
//	※ 2026-09 マルチDB: UNION の並べ替えは CAST(.. AS SIGNED) ではなく数値リテラル 0 + 列別名で行う（SQLite は複合SELECTの ORDER BY に式を書けない）
//	場面並び順のCSVﾃﾞｰﾀ を 取得する
//		$csvArray = swFunc_MakeSelectItemsCsvSceneOrderNo($mySqlConnObj,$fdtScenarioId)
//--------------------------------------------------------------------------------
function swFunc_MakeSelectItemsCsvSceneOrderNo($mySqlConnObj,$fdtScenarioId){

	$strSQL = <<<END_OF_SQL

		SELECT CONCAT(SCENE_ORDER_NO,':',SCENE_NAME)	AS	CSVITEM
			, SCENE_ORDER_NO							AS	SCENE_ORDER_NO
			FROM SW_SCENE
			WHERE SCENARIO_ID = '$fdtScenarioId'
		UNION
			SELECT CONCAT(SCENE_ORDER_NO + 50,':',SCENE_NAME,'の後')	AS	CSVITEM
				, SCENE_ORDER_NO + 50									AS	SCENE_ORDER_NO
				FROM SW_SCENE
				WHERE SCENARIO_ID = '$fdtScenarioId'
		UNION
			SELECT '0:最初の場面'	AS	CSVITEM
				, 0				AS	SCENE_ORDER_NO
			ORDER BY SCENE_ORDER_NO DESC;
END_OF_SQL;

	// SQL を実行して CSV 配列を返す (-1:---　を表示)
	return swFunc_ResultToCsvArray($mySqlConnObj,$strSQL,FALSE,'');

}

//--------------------------------------------------------------------------------
//	登場人物並び順のCSVﾃﾞｰﾀ を 取得する
//		$csvArray = swFunc_MakeSelectItemsCsvCharacterOrderNo($mySqlConnObj,$fdtScenarioId)
//--------------------------------------------------------------------------------
function swFunc_MakeSelectItemsCsvCharacterOrderNo($mySqlConnObj,$fdtScenarioId){

	$strSQL = <<<END_OF_SQL

		SELECT CONCAT(CHARACTER_ORDER_NO,':',CHARACTER_NAME)		AS	CSVITEM
			, CHARACTER_ORDER_NO							AS	CHARACTER_ORDER_NO
			FROM SW_CHARACTER
			WHERE SCENARIO_ID = '$fdtScenarioId'
		UNION
			SELECT CONCAT(CHARACTER_ORDER_NO + 50,':',CHARACTER_NAME,'の次')		AS	CSVITEM
				, CHARACTER_ORDER_NO + 50									AS	CHARACTER_ORDER_NO
				FROM SW_CHARACTER
				WHERE SCENARIO_ID = '$fdtScenarioId'
		UNION
			SELECT '0:最初の登場人物'			AS	CSVITEM
				, 0				AS	CHARACTER_ORDER_NO
			ORDER BY CHARACTER_ORDER_NO;
END_OF_SQL;

	// SQL を実行して CSV 配列を返す (-1:---　を表示)
	return swFunc_ResultToCsvArray($mySqlConnObj,$strSQL,FALSE,'');

}

//--------------------------------------------------------------------------------
//	USER STYLE並び順のCSVﾃﾞｰﾀ を 取得する
//		$csvArray = swFunc_MakeSelectItemsCsvUserOptionStyleOrderNo($mySqlConnObj,$fdtUserId)
//--------------------------------------------------------------------------------
function swFunc_MakeSelectItemsCsvUserOptionStyleOrderNo($mySqlConnObj,$fdtUserId){
	//登録があるか確認
	$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER_OPTION
				WHERE USER_ID = :UserId;
END_OF_SQL;
	$stmt = $mySqlConnObj->prepare($strSQL);
	//パラメータのセット
	$stmt->bindParam(':UserId', $fdtUserId, PDO::PARAM_INT);
	$stmt->execute();
	//件数取得
	$myRowCnt = $stmt->rowCount();
	if($myRowCnt == 0 ){
		$csvArray = array();
		array_push($csvArray,"100:セリフ");
		array_push($csvArray,"150:セリフの次");
		array_push($csvArray,"200:ト書");
		array_push($csvArray,"250:ト書の次");
		array_push($csvArray,"300:歌詞");
		array_push($csvArray,"350:歌詞の次");
		array_push($csvArray,"400:ナレーション");
		array_push($csvArray,"450:ナレーションの次");
		array_push($csvArray,"500:モノローグ");
		array_push($csvArray,"550:モノローグの次");
		array_push($csvArray,"600:テロップ");
		array_push($csvArray,"650:テロップの次");
		array_push($csvArray,"700:演技指示");
		array_push($csvArray,"750:演技指示の次");
		array_push($csvArray,"800:音響指示");
		array_push($csvArray,"850:音響指示の次");
		array_push($csvArray,"900:照明指示");
		array_push($csvArray,"950:照明指示の次");

		return	$csvArray;
	}

	$strSQL = <<<END_OF_SQL

		SELECT CONCAT(USER_OPTION_STYLE_ORDER_NO,':',USER_OPTION_STYLE_NAME)	AS	CSVITEM
			, USER_OPTION_STYLE_ORDER_NO							AS	USER_OPTION_STYLE_ORDER_NO
			FROM SW_USER_OPTION
			WHERE USER_ID = '$fdtUserId'
		UNION
			SELECT CONCAT(USER_OPTION_STYLE_ORDER_NO + 50,':',USER_OPTION_STYLE_NAME,'の次')	AS	CSVITEM
				, USER_OPTION_STYLE_ORDER_NO + 50									AS	USER_OPTION_STYLE_ORDER_NO
				FROM SW_USER_OPTION
				WHERE USER_ID = '$fdtUserId'
		UNION
			SELECT '0:最初のスタイル'	AS	CSVITEM
				, 0				AS	USER_OPTION_STYLE_ORDER_NO
			ORDER BY USER_OPTION_STYLE_ORDER_NO;
END_OF_SQL;

	// SQL を実行して CSV 配列を返す (-1:---　を表示)
	return swFunc_ResultToCsvArray($mySqlConnObj,$strSQL,FALSE,'');

}

//--------------------------------------------------------------------------------
//	CSVからマッチする項目を返す
//--------------------------------------------------------------------------------
function swFunc_GetArrayItem($Code,$csvArray){
	foreach ($csvArray as $tmp) {
    	$wArray = explode(':',$tmp);
    	$wCode = $wArray[0];
    	$wCodeMei = $wArray[1];

		if ($wCode == $Code) {
			$wCodeMei = str_replace('---','',$wCodeMei);
			return $wCodeMei;
		}
	}
}
// ------------------------------------------------------------------------------
// 月のCSVﾃﾞｰﾀ を 取得する
//		$csvArray = swFunc_MakeMmCsv()
// ------------------------------------------------------------------------------
function swFunc_MakeMmCsv(){
	$csvArray = array();
	for( $i = 1 ; $i <= 12 ;$i++ ){
		$mm_value = $i;
		array_push($csvArray,$mm_value.":".$i."月");
	}
	return	$csvArray;
}
// ------------------------------------------------------------------------------
// CSVﾃﾞｰﾀ sample
// swFunc_MakeSelectItemsCsvSample
// ------------------------------------------------------------------------------
function swFunc_MakeSelectItemsCsvSample(){

	$csvArray = array();
	array_push($csvArray,"-1:選択");
	array_push($csvArray,"1:SELECT 1");
	array_push($csvArray,"2:SELECT 2");
	array_push($csvArray,"3:SELECT 3");
	array_push($csvArray,"5:SELECT 5");
	array_push($csvArray,"7:SELECT 7");
	array_push($csvArray,"9:SELECT 9");

	return	$csvArray;
}
// ------------------------------------------------------------------------------
// CSVﾃﾞｰﾀからselect box を作成する Bootstrap3
//		$ObjName		: select box の名称
//		$csvArray	: CSVﾃﾞｰﾀ
//		$default	: ﾃﾞﾌｫﾙﾄ値
//		$onChange	: onChange で起動する java script関数名
//		$ViewCode	: ｺｰﾄﾞを表示する
//		$retHTML = swFunc_MakeSelectBox($ObjName,$csvArray,$default,$onChange,$ViewCode)
// ------------------------------------------------------------------------------
function swFunc_MakeSelectBox($ObjName,$csvArray,$default,$onChange,$ViewCode){
	// onChangeを使わない場合
	if ( $onChange == ''){
		$retHTML = "<select class=\"form-control\"";
		$retHTML .= " name=\"$ObjName\" id=\"$ObjName\"";
		$retHTML .= ">\n";
	}else{
		$retHTML = "<select class=\"form-control\"";
		$retHTML .= " name=\"$ObjName\" id=\"$ObjName\"";
		$retHTML .= " onChange=\"$onChange\"";
		$retHTML .= ">\n";
	}
	//CSVの要素を取り出す
	$retOption = "";
	//1件以下はselectedにする
	if ( count($csvArray) <= 1 ){
		$i = 0;
		//valueとitemに分ける
		$arr = explode(":",$csvArray[$i]);
		//Option生成
		//ｺｰﾄﾞを表示するか
		if ( $ViewCode == TRUE ){
			$csvArray[$i] = str_replace('-1:','',$csvArray[$i]);
			$retOption .= "<option value=\"" .$arr[0]."\" selected>".$csvArray[$i]."</option>\n";
		}else{
			if(isset($arr[1])){
				$retOption .= "<option value=\"" .$arr[0]."\" selected>".$arr[1]."</option>\n";
			}
		}
	}else{
		//ﾏｯﾁしたかをﾁｪｯｸする
		$retOption = "";
		$matchCode = FALSE;
		for($i = 0; $i < count($csvArray); $i++){
			//valueとitemに分ける
			$arr = explode(":",$csvArray[$i]);
			//Option生成
			//ｺｰﾄﾞを表示するか
			if ( $ViewCode == TRUE ){
				$csvArray[$i] = str_replace('-1:','',$csvArray[$i]);

				if ($default == $arr[0]) {
					$matchCode = TRUE;
					$retOption .= "<option value=\"" .$arr[0]."\" selected>".$csvArray[$i]."</option>\n";
				}
				else {
					$retOption .= "<option value=\"" .$arr[0]."\">".$csvArray[$i]."</option>\n";
				}
			}else{
				if ($default == $arr[0]) {
					$matchCode = TRUE;
					$retOption .= "<option value=\"" .$arr[0]."\" selected>".$arr[1]."</option>\n";
				}
				else {
					$retOption .= "<option value=\"" .$arr[0]."\">".$arr[1]."</option>\n";
				}
			}
	    }
	    //ﾏｯﾁしていない場合，最初の要素をselectedにする
	    if ( !$matchCode ){
	    	$retOption = "";
			for($i = 0; $i < count($csvArray); $i++){
				//valueとitemに分ける
				$arr = explode(":",$csvArray[$i]);
				//Option生成
				if ( $ViewCode == TRUE ){
					if ($i == 0) {
						$retOption .= "<option value=\"" .$arr[0]."\" selected>".$csvArray[$i]."</option>\n";
					}
					else {
						$retOption .= "<option value=\"" .$arr[0]."\">".$csvArray[$i]."</option>\n";
					}
				}else{
					if ($i == 0) {
						$retOption .= "<option value=\"" .$arr[0]."\" selected>".$arr[1]."</option>\n";
					}
					else {
						$retOption .= "<option value=\"" .$arr[0]."\">".$arr[1]."</option>\n";
					}
				}
		    }
	    }
    }
	$retHTML .= $retOption."</select>\n";

	return	$retHTML;
}

// ------------------------------------------------------------------------------
// 現在の日付を取得する
//		$currentDate = swFunc_GetCurrentDate();
// ------------------------------------------------------------------------------
function swFunc_GetCurrentDate(){
	return date("Y\/m\/d");
}
// ------------------------------------------------------------------------------
//		現在の日付を取得する
// ------------------------------------------------------------------------------
function swFunc_GetNowDate(){
	//現在の日付を取得
	$today = getdate();
	$THIS_YEAR = sprintf( "%04d",$today["year"]);
	$THIS_MON = sprintf( "%02d",$today["mon"]);
	$THIS_DAY = sprintf( "%02d",$today["mday"]);

	return $THIS_YEAR.'/'.$THIS_MON.'/'.$THIS_DAY;
}
// ------------------------------------------------------------------------------
// 現在の年度を取得する
//		$currentNendo = swFunc_GetCurrentNendo($mySqlConnObj,$EmpCd);
// ------------------------------------------------------------------------------
function swFunc_GetCurrentNendo($mySqlConnObj,$EmpCd,$CompanyCd='-1'){
	$today_date = date("Y\/m\/d");

	// 年度取得
	if (substr($today_date,5,2) < 4){
		$currentNendo = date("Y") - 1;
	}else {
		$currentNendo = date("Y");
	}
	return $currentNendo;
}
// ------------------------------------------------------------------------------
// ｶﾚﾝﾀﾞｰ付日付選択を作成
//		$mySqlConnObj	: SQLｸﾗｽｵﾌﾞｼﾞｪｸﾄ
//		$ObjName		: Select Name
//		$default 	: 日付ﾃﾞｰﾀ ( YYYY/MM/DD )
//		$mode		: 初期値を現在にする
//		$retHtml = swFunc_MakeCalendarBox($mySqlConnObj,$ObjName,$default,$mode,$onChange)
// ------------------------------------------------------------------------------
function swFunc_MakeCalendarBox($mySqlConnObj,$formName,$ObjName,$defaultDate,$mode,$onChange){
	$YearBoxNmae = $ObjName.'YY';
	$MonthBoxNmae = $ObjName.'MM';
	$DayBoxNmae = $ObjName.'DD';

	$retHtml = '';
	//年
	$retHtml .= swFunc_MakeYearSelectBox($mySqlConnObj,$YearBoxNmae,$defaultDate,$mode,$onChange);
	//月
	$retHtml .= swFunc_MakeMonthSelectBox($MonthBoxNmae,$defaultDate,$mode,$onChange);
	//日
	$retHtml .= swFunc_MakeDaySelectBox($DayBoxNmae,$defaultDate,$mode,$onChange);
	//ｶﾚﾝﾀﾞｰのﾎﾟｯﾌﾟｱｯﾌﾟ(calendar/)は 2026-09 に廃止。年月日の SELECT だけ返す
	return $retHtml;

}
// ------------------------------------------------------------------------------
//		西暦 → 和暦
//
//		変換モード
//		$hMode:0 --> 年月日変換
//		$hMode:1 --> 年変換
//
//		元号表現
//		$gMode:0 --> 平成
//		$gMode:1 --> 平
//		$gMode:2 --> H
//		$gMode:3 --> 4
//
//		前ゼロ
//		$zMode:0 --> 前ゼロなし
//		$zMode:1 --> 前ゼロあり
//
//		区切り文字
//		$sep:0 --> 年月日
//		$sep:1 --> ///
//		$sep:2 --> ...
//
//		$wDate = swFunc_SWHenkan($sDate,$hMode,$gMode,$nMode,$sMode)
// ------------------------------------------------------------------------------
function swFunc_SWHenkan($sDate,$hMode='0',$gMode='0',$zMode='0',$sep='0'){
	//$sDateを指定しない場合はtoday
	if($sDate == '' or strpos($sDate,'/') ===false ){
		$sDate = swFunc_GetNowDate();
	}
	//西暦を分解
    list($year, $month, $day) = explode('/', $sDate);
    //西暦ﾁｪｯｸ
    if (!@checkdate($month, $day, $year) or $year < 1869 or strlen($year) !== 4
            or strlen($month) !== 2 or strlen($day) !== 2){
       return '';
	}
	//日付ｾﾊﾟﾚｰﾀを削除
    $sDate = str_replace('/', '', $sDate);

	//元号を判定
	$gengo = '0';
    if ($sDate >= 19890108) {
        $gengo = '4';
        $wYear = $year - 1988;
    } elseif ($sDate >= 19261225) {
        $gengo = '3';
        $wYear = $year - 1925;
    } elseif ($sDate >= 19120730) {
        $gengo = '2';
        $wYear = $year - 1911;
    } else {
        $gengo = '1';
        $wYear = $year - 1868;
    }
    //元号配列
    switch ($gMode){
    	case 0:
    		$gArray = array();
			array_push($gArray,"---");
			array_push($gArray,"明治");
			array_push($gArray,"大正");
			array_push($gArray,"昭和");
    		array_push($gArray,"平成");
            break;
    	case 1:
    		$gArray = array();
			array_push($gArray,"---");
			array_push($gArray,"明");
			array_push($gArray,"大");
			array_push($gArray,"昭");
    		array_push($gArray,"平");
            break;
    	case 2:
    		$gArray = array();
			array_push($gArray,"---");
			array_push($gArray,"M");
			array_push($gArray,"T");
			array_push($gArray,"S");
    		array_push($gArray,"H");
            break;
        default:
    		$gArray = array();
			array_push($gArray,"---");
			array_push($gArray,"1");
			array_push($gArray,"2");
			array_push($gArray,"3");
    		array_push($gArray,"4");
	}
	//配列から元号を取得
	if(isset($gArray[$gengo])){
		$wGengo = $gArray[$gengo];
	}else{
		$wGengo = '??';
	}
	//前ゼロ
	if($zMode == '0'){
		$wYear = LTRIM($wYear,'0');
		$month = LTRIM($month,'0');
		$day = LTRIM($day,'0');
		if($wYear == '1'){
			$wYear = '元';
		}
	}
	//変換ﾓｰﾄﾞ(年ﾓｰﾄﾞ）
	if($hMode == '1'){
		switch ($sep){
			case 0:
				$wDate = $wGengo.$wYear.'年';
            	break;
        	default:
            	$wDate = $wGengo.$wYear;
    	}
		return	$wDate;
	}
//		$sep:0 --> 年月日
//		$sep:1 --> ///
//		$sep:2 --> ...
	switch ($sep){
		case 1://$sep:1 --> ///
			$wDate = $wGengo.$wYear.'/'.$month.'/'.$day;
        	break;
		case 2://$sep:2 --> ...
			$wDate = $wGengo.$wYear.'.'.$month.'.'.$day;
        	break;
    	default://$sep:0 --> 年月日
        	$wDate = $wGengo.$wYear.'年'.$month.'月'.$day.'日';
	}
    return $wDate;
}

// ------------------------------------------------------------------------------
//		年フィールド 西暦 → 和暦
//		$date (yyyy/mm/dd)
//		$mode TRUE -> 現在の日付をｾｯﾄする
//      $retHtml = swFunc_MakeYearSelectBox($mySqlConnObj,$ObjName,$date,$mode,$onChange)
// ------------------------------------------------------------------------------
function swFunc_MakeYearSelectBox($mySqlConnObj,$ObjName,$date,$mode,$onChange){
	$ymd = swFunc_SplitDate($date);
	$date = sprintf('%04d/%02d/%02d', $ymd[0], $ymd[1], $ymd[2]);
	//現在の日付を取得
	$today = getdate();
	$THIS_YEAR = sprintf( "%04d",$today['year']);
	$tgtYEAR = sprintf( "%04d",substr($date,0,4));
	if ($mode == TRUE){
		if ($tgtYEAR == '0000'){$tgtYEAR = $THIS_YEAR;}
	}
	// 和暦CSV を編集
	$stYear = $THIS_YEAR - _STNEN_;
	$edYear = $THIS_YEAR + _EDNEN_;
	$csvArray = array();
	array_push($csvArray,"0000:----");
	for( $i = $stYear ; $i <= $edYear ;$i++ ){
		//表示は西暦年（以前は「西暦年/12/31」と表示されていた）
		array_push($csvArray,$i.":".$i);
	}

	// CSVﾃﾞｰﾀからselect box を作成する
	$retHtml = swFunc_MakeSelectBox($ObjName,$csvArray,$tgtYEAR,65,$onChange,FALSE);

	$retHtml .= <<<END_OF_HTML
	<span class="fBlack10100">年</span>
END_OF_HTML;
	return $retHtml;

}
// ------------------------------------------------------------------------------
//		月フィールド
//		$date (yyyy/mm/dd)
//		$mode TRUE -> 現在の日付をｾｯﾄする
//      $retHtml = swFunc_MakeMonthSelectBox($ObjName,$date,$mode,$onChange)
// ------------------------------------------------------------------------------
function swFunc_MakeMonthSelectBox($ObjName,$date,$mode,$onChange){
	$ymd = swFunc_SplitDate($date);
	$date = sprintf('%04d/%02d/%02d', $ymd[0], $ymd[1], $ymd[2]);
	//現在の日付を取得
	$today = getdate();
	$THIS_MON = sprintf( "%02d",$today['mon']);
	$tgtMON = sprintf( "%02d",substr($date,5,2));
	if ($mode == TRUE){
		if ($tgtMON == '00'){$tgtMON = $THIS_MON;}
	}
	$csvArray = array();
	array_push($csvArray,"00:--");
	for( $i = 1 ; $i <= 12 ;$i++ ){
		//$mm_value = sprintf( "%02d",$i);
		$mm_value = $i;
		array_push($csvArray,$mm_value.":".$i);
	}
	// CSVﾃﾞｰﾀからselect box を作成する
	$retHtml = swFunc_MakeSelectBox($ObjName,$csvArray,$tgtMON,40,$onChange,FALSE);

	$retHtml .= <<<END_OF_HTML
	<span class="fBlack10100">月</span>
END_OF_HTML;
	return $retHtml;
}
// ------------------------------------------------------------------------------
//		日フィールド
//		$mode TRUE -> 現在の日付をｾｯﾄする
//      $retHtml = swFunc_MakeDaySelectBox($ObjName,$date,$mode,$onChange)
// ------------------------------------------------------------------------------
function swFunc_MakeDaySelectBox($ObjName,$date,$mode,$onChange){
	$ymd = swFunc_SplitDate($date);
	$date = sprintf('%04d/%02d/%02d', $ymd[0], $ymd[1], $ymd[2]);
	//現在の日付を取得
	$today = getdate();
	$THIS_DAY = sprintf( "%02d",$today['mday']);
	$tgtDAY = sprintf( "%02d",substr($date,8,2));
	if ($mode == TRUE){
		if ($tgtDAY == '00'){$tgtDAY = $THIS_DAY;}
	}
	$csvArray = array();
	array_push($csvArray,"00:--");
	for( $i = 1 ; $i <= 31 ;$i++ ){
		//$dd_value = sprintf( "%02d",$i);
		$dd_value = $i;
		array_push($csvArray,$dd_value.":".$i);
	}
	// CSVﾃﾞｰﾀからselect box を作成する
	$retHtml = swFunc_MakeSelectBox($ObjName,$csvArray,$tgtDAY,40,$onChange,FALSE);
	$retHtml .= <<<END_OF_HTML
	<span class="fBlack10100">日</span>
END_OF_HTML;
	return $retHtml;
}

//--------------------------------------------------------------------------------
//	date を 年，月，日に分割
//	$SpritYmd = swFunc_SplitDate($date)
//--------------------------------------------------------------------------------
function swFunc_SplitDate($date){
	if( $date == ''){
		$date = '///';
	}
	if ( mb_strpos($date,'-') > 0 ){
		$SpritYmd = explode("-",$date);
	}else{
		$SpritYmd = explode("/",$date);
	}
	return	$SpritYmd;
}
// ------------------------------------------------------------------------------
// Resultを編集してCSV配列を作る
//		$retArray = swFunc_ResultToCsvArray($mySqlConnObj,$strSQL,$NoneCd,$msg);
// ------------------------------------------------------------------------------
function swFunc_ResultToCsvArray($mySqlConnObj,$strSQL,$NoneCd,$msg){

    //SQL実行
	$stmt = $mySqlConnObj->prepare($strSQL);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$stmt->execute();
    //件数取得
    $myRowCnt = $stmt->rowCount();
	// 0 件のときの制御
	if ( $NoneCd == FALSE){
		//制御をしない場合
		if ( $myRowCnt == 0 ){
			//0件なら ---- を表示
			$csvArray = array("-1:----");
		}else{
			//特定ﾒｯｾｰｼﾞがないときは配列を初期化
			if ( $msg == ''){
				$csvArray = array();
			}else{
				$csvArray = array("-1:$msg");
			}
		}
	}else{
		//制御をする場合
		if ( $msg == ''){
			//特定ﾒｯｾｰｼﾞがないとき
			if ( $myRowCnt == 0 ){
				//0件なら ---- を表示
				$csvArray = array("-1:----");
			}else{
				//0件以上なら 選択 を表示
				$csvArray = array("-1:選択");
			}
		}else{
			//特定ﾒｯｾｰｼﾞがあるとき
			$csvArray = array("-1:$msg");
		}
	}
	//特定ﾒｯｾｰｼﾞがNONEのとき配列を初期化
	if ( $msg == 'NONE'){
		$csvArray = array();
	}

	$brakeItem = '';
	while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		$CSVITEM = $myRow["CSVITEM"];
		if ( $CSVITEM == $brakeItem){
		}else{
			array_push($csvArray,"$CSVITEM");
			$brakeItem = $CSVITEM;
		}
	}
	return $csvArray;
}
// ------------------------------------------------------------------------------
// JAVA SCRIPT でダイアログを表示する
// ------------------------------------------------------------------------------
function swFunc_Alert($AlertMsg){
	print <<<END_OF_HTML
		<Script language="JavaScript">
			alert("$AlertMsg");
		</Script>
END_OF_HTML;
}
// ------------------------------------------------------------------------------
// Debug Print
// ------------------------------------------------------------------------------
function swFunc_DebugPrint($item){
	echo "Debug = $item<br>";

}
// ------------------------------------------------------------------------------
// Debug Exit
// ------------------------------------------------------------------------------
function swFunc_DebugExit($item){
	echo "Debug = $item<br>";
	exit;

}
// ------------------------------------------------------------------------------
// 使用する/使用しないのCSVﾃﾞｰﾀ を 取得する
//		$csvArray = swFunc_MakeUseOrNotCsv()
// ------------------------------------------------------------------------------
function swFunc_MakeUseOrNotCsv(){
	$csvArray = array();
	array_push($csvArray,"-1:選択してください");
	array_push($csvArray,"0:使用しない");
	array_push($csvArray,"1:使用する");
	return	$csvArray;
}
// ------------------------------------------------------------------------------
// 数字編集
//		$ret = swFunc_NumberFormat($Num)
// ------------------------------------------------------------------------------
function swFunc_NumberFormat($Num){
	//PHP8: number_format() に数値でない文字列(空文字等)を渡すと TypeError になるため先に判定する
	if ( !is_numeric($Num) || $Num == 0 ){
		return	'';
	}else{
		return	number_format((float)$Num);
	}
}
// ------------------------------------------------------------------------------
// 西暦-> 和暦
//		$date(yyyy/mm/dd) --> 年号 xx 年 xx 月 xx 日
//	変換ﾊﾟﾀｰﾝ(012345)
//		0= K	漢字区切り 　　　年　　月　　日
//		0= S	/ 区切り 　　　/　　/　　/
//		0= P	. 区切り 　　　.　　.　　.
//		1= W	和暦
//		1= w	和暦 1文字
//		1= g	MTSH 1文字
//		2= y	和暦年　前ゼロあり
//		2= Y	和暦年　前ゼロなし
//		3= m	和暦月　前ゼロあり
//		3= M	和暦月　前ゼロなし
//		4= d	和暦日　前ゼロあり
//		4= D	和暦日　前ゼロなし
//		5= S	数字と区切りに空白なし
// ------------------------------------------------------------------------------
function swFunc_S2WDate($date,$pattern='KWYMD'){
	$PatArr = array(substr($pattern,0,1)
					,substr($pattern,1,1)
					,substr($pattern,2,1)
					,substr($pattern,3,1)
					,substr($pattern,4,1)
					,substr($pattern,5,1));
	$SepPat = $PatArr[0].$PatArr[5];
	if ( $date == NULL ){
		return "";
	}
	//日付分割
	$sDate = "$date";
	$tgtDate = swFunc_explodeDate($sDate);

	//元号配列
	//		1= W	和暦
	//		1= w	和暦 1文字
	//		1= g	MTSH 1文字
	switch($PatArr[1]){
		case 'W':
			$GENGO = array('明治 ','大正 ','昭和 ','平成 ');
			break;
		case 'w':
			$GENGO = array('明','大','昭','平');
			break;
		case 'g':
			$GENGO = array('M','T','S','H');
			break;
		default:
			$GENGO = array('明治','大正','昭和','平成');
			break;
	}

    $year = $tgtDate[0];
    if ($sDate <= "19120729") {
        $Gengo = $GENGO[0];
        $wareki = $year - 1867;
    } else if ($sDate >= "19120730" && $sDate <= "19261224") {
        $Gengo = $GENGO[1];
        $wareki = $year - 1911;
    } else if ($sDate >= "19261225" && $sDate <= "19890107") {
        $Gengo = $GENGO[2];
        $wareki = $year - 1925;
    } else if ($sDate >= "19890108") {
        $Gengo = $GENGO[3];
        $wareki = $year - 1988;
    }
	//区切り文字
	//		0= K	漢字区切り 　　　年　　月　　日
	//		0= S	/ 区切り 　　　/　　/　　/
	//		0= P	. 区切り 　　　.　　.　　.
	//		5= S	数字と区切りに空白なし
	$SepPat = $PatArr[0].$PatArr[5];
	switch($SepPat){
		case 'KS':
			$STR_SEP = array(' 年 ','月 ','日');
			break;
		case 'SS':
			$STR_SEP = array(' /',' /','');
			break;
		case 'PS':
			$STR_SEP = array(' .',' .','');
			break;
		case 'K':
			$STR_SEP = array('年','月','日');
			break;
		case 'S':
			$STR_SEP = array('/','/','');
			break;
		case 'P':
			$STR_SEP = array('.','.','');
			break;
		default:
			$STR_SEP = array(' 年',' 月',' 日');
			break;
	}
	//		2= y	和暦年　前ゼロあり
	//		2= Y	和暦年　前ゼロなし
	switch($PatArr[2]){
		case 'Y':
			$WYear = LTRIM($wareki,'0');
			break;
		case 'y':
			$WYear = $wareki;
			break;
		default:
			$WYear = LTRIM($wareki,'0');
			break;
	}
	//		3= m	和暦月　前ゼロあり
	//		3= M	和暦月　前ゼロなし
	switch($PatArr[3]){
		case 'M':
			$Month = LTRIM($tgtDate[1],'0');
			break;
		case 'm':
			$Month = $tgtDate[1];
			break;
		default:
			$Month = LTRIM($tgtDate[1],'0');
			break;
	}
	//		4= d	和暦日　前ゼロあり
	//		4= D	和暦日　前ゼロなし
	switch($PatArr[4]){
		case 'D':
			$Day = LTRIM($tgtDate[2],'0');
			break;
		case 'd':
			$Day = $tgtDate[2];
			break;
		default:
			$Day = LTRIM($tgtDate[2],'0');
			break;
	}
	//文字列連結(前ゼロなし）
	$retWDate =  $Gengo.$WYear.$STR_SEP[0].$Month.$STR_SEP[1].$Day.$STR_SEP[2];
	return $retWDate;
}
//--------------------------------------------------------------------------------
//	date を 年，月，日に分割
//	$SpritYmd = swFunc_explodeDate($date)
//--------------------------------------------------------------------------------
function swFunc_explodeDate($date){
	if ( mb_strpos($date,'-') > 0 ){
		$SpritYmd = explode("-",$date);
	}else{
		$SpritYmd = explode("/",$date);
	}
	return	$SpritYmd;
}
// ------------------------------------------------------------------------------
// 年月日と加算日からn日後、n日前を求める関数
// $year 年
// $month 月
// $day 日
// $addDays 加算日。マイナス指定でn日前も設定可能
// ------------------------------------------------------------------------------
function swFunc_ComputeDate($year, $month, $day, $addDays){
    $baseSec = mktime(0, 0, 0, $month, $day, $year);//基準日を秒で取得
    $addSec = $addDays * 86400;//日数×１日の秒数
    $targetSec = $baseSec + $addSec;

    return date("Y/m/d", $targetSec);
}
// ------------------------------------------------------------------------------
// $start_ymdから$end_ymdの日数を求める関数
//	$diffDay = swFunc_GetDays($start_ymd,$end_ymd)
// 		$start_ymd	(yyyy/mm/dd)
// 		$end_ymd	(yyyy/mm/dd)
// ------------------------------------------------------------------------------
function swFunc_GetDays($start_ymd,$end_ymd){
	if ($start_ymd == ''){return 0;}
	if ($end_ymd == ''){return 0;}
	$diffDay = swFunc_GetDiffDays($start_ymd,$end_ymd);
	$Days = $diffDay + 1;

	return $Days;
}
//------------------------------------------------------------------------
// 任意の年月の第n 曜日の日付を求める関数
// 		$year 年
// 		$month 月
// 		$number 何番目の曜日か、第1曜日なら1。第3曜日なら3
// 		$dayOfWeek 求めたい曜日。0-6までの数字で曜日の日～土を指定する
//------------------------------------------------------------------------
function swFunc_GetWhatDayOfWeek($year, $month, $number, $dayOfWeek) {
	//指定した年月の1日の曜日を取得
    $firstDayOfWeek = date("w", mktime(0, 0, 0, $month, 1, $year));
    $day = $dayOfWeek - $firstDayOfWeek + 1;
    //1週間を足す
    if($day <= 0) $day += 7;
    $dt = mktime(0, 0, 0, $month, $day, $year);
    //n曜日まで1週間を足し込み
    $dt += (86400 * 7 * ($number - 1));

    $date = date("Y/m/d", $dt);
    $ymd = swFunc_SplitDate($date);

    $retYmd = sprintf("%04d/%02d/%02d", $ymd[0], $ymd[1], $ymd[2]);

    return	$retYmd;
}
//------------------------------------------------------------------------
// 指定した日の曜日を取得
//------------------------------------------------------------------------
function swFunc_GetDayOfWeek($date){
	$sDate = "$date";
	if ($sDate == ''){return '';}
	if ( mb_strpos($date,'-') > 0 ){
		$tgtDate = explode("-",$sDate);
	}else{
		$tgtDate = explode("/",$sDate);
	}
	if(count($tgtDate) == 0 ){
		return '';
	}
	//指定した年月日の曜日を取得
    $DayOfWeek = date("w", mktime(0, 0, 0, $tgtDate[1],$tgtDate[2], $tgtDate[0]));
    return swFunc_GetWDay($DayOfWeek);
}
//------------------------------------------------------------------------
// 指定した月の末日を取得
//------------------------------------------------------------------------
function swFunc_GetLastDayOfMonth($date){
	$sDate = "$date";
	if ( mb_strpos($date,'-') > 0 ){
		$tgtDate = explode("-",$sDate);
	}else{
		$tgtDate = explode("/",$sDate);
	}
	$LastDayDate = mktime(0, 0, 0, $tgtDate[1] + 1, 0, $tgtDate[0]);
	return date("d", $LastDayDate);
}
// ------------------------------------------------------------------------------
// yyyy/mm/dd を年月日に配列化する
//	$ymd_array = swFunc_DivideYmd($ymd)
// 		$start_ymd	(yyyy/mm/dd)
// 		$end_ymd	(yyyy/mm/dd)
// ------------------------------------------------------------------------------
function swFunc_DivideYmd($ymd){
	$ymd_array = swFunc_SplitDate($ymd);
	$ymd_array[0] = sprintf( "%04d",$ymd_array[0]);
	$ymd_array[1] = sprintf( "%02d",$ymd_array[1]);
	$ymd_array[2] = sprintf( "%02d",$ymd_array[2]);

	return	$ymd_array;
}
// ------------------------------------------------------------------------------
// $start_ymdから$end_ymdの差を求める関数
//	$diffDay = swFunc_GetDiffDays($start_ymd,$end_ymd)
// 		$start_ymd	(yyyy/mm/dd)
// 		$end_ymd	(yyyy/mm/dd)
// ------------------------------------------------------------------------------
function swFunc_GetDiffDays($start_ymd,$end_ymd){
	//echo "$end_ymd";
	if ($start_ymd == ''){return 0;}
	if ($end_ymd == ''){return 0;}

	//開始日
	$ymd = swFunc_SplitDate($start_ymd);
	$start_year = $ymd[0];
	$start_month = $ymd[1];
	$start_day = $ymd[2];
	//終了日
	$ymd = swFunc_SplitDate($end_ymd);
	$end_year = $ymd[0];
	$end_month = $ymd[1];
	$end_day = $ymd[2];

	//dateﾀｲﾌﾟに変換
    $start_date = mktime(0, 0, 0, $start_month, $start_day, $start_year);
    $end_date = mktime(0, 0, 0, $end_month, $end_day, $end_year);
    //差を求める
    $Difference = $end_date - $start_date;
    //1日は86400秒　日数に変換
    $diffDay = $Difference / 86400;
    return $diffDay;
}
// ------------------------------------------------------------------------------
// CloseButtonを作成
// ------------------------------------------------------------------------------
function swFunc_GetCloseButton($onClick,$alt){
	$retHTML = <<<END_OF_HTML
		<img src="./css/images/closeButton.png" alt="$alt"
			onclick="$onClick"
			style="cursor: pointer; margin: 6px 10px 0px 4px;"
		>
END_OF_HTML;
	return	$retHTML;
}
// ------------------------------------------------------------------------------
// 時間編集ｷｬﾝｾﾙﾎﾞﾀﾝ
// ------------------------------------------------------------------------------
function swFunc_GetReservedTimeEditCancelButton($onClick,$alt){
	$retHTML = <<<END_OF_HTML
		<img src="./css/images/closeButton.png" alt="$alt"
			onclick="$onClick"
			style="cursor: pointer;"
		>
END_OF_HTML;
	return	$retHTML;
}
// ------------------------------------------------------------------------------
// ｷｬﾝｾﾙﾎﾞﾀﾝ
// ------------------------------------------------------------------------------
function swFunc_MakeCancelButton($onClick,$alt){
	$retHTML = <<<END_OF_HTML
		<img src="./css/images/closeButton.png" alt="$alt"
			onclick="$onClick"
			style="cursor: pointer;"
		>
END_OF_HTML;
	return	$retHTML;
}
// ------------------------------------------------------------------------------
// 日本語曜日選択のSELECT BOX を取得する
//		swFunc_MakeWDaySelectBox($ObjName,$Default,$onchange)
// ------------------------------------------------------------------------------
function swFunc_MakeWDaySelectBox($ObjName,$Default,$onchange){
	//曜日
	$csvArray = array( "0:日", "1:月", "2:火", "3:水", "4:木", "5:金", "6:土" );
	// CSVﾃﾞｰﾀからSelectBox を作成する
	return swFunc_MakeSelectBox($ObjName,$csvArray,$Default,50,$onchange,FALSE);
}
// ------------------------------------------------------------------------------
// 日本語曜日 を 取得する
//		swFunc_GetWDay($wDay)
// ------------------------------------------------------------------------------
function swFunc_GetWDay($wDay){
	//曜日
	$WeekDayArray = array( "日", "月", "火", "水", "木", "金", "土" );
	return	$WeekDayArray[$wDay];
}
// ------------------------------------------------------------------------------
// ﾁｪｯｸﾎﾞｯｸｽを作成する
//		$ObjName		: ﾁｪｯｸﾎﾞｯｸｽ の名称
//		$value		: ﾁｪｯｸﾎﾞｯｸｽ の値
//		$Default	: ﾃﾞﾌｫﾙﾄ値
//		$onChange	: onChange で起動する java script関数名
//		$retHTML = swFunc_MakeCheckBox($ObjName,$csvArray,$Default,$onChange)
// ------------------------------------------------------------------------------
function swFunc_MakeCheckBox($ObjName,$value,$Default,$onChange){

	//echo "name = $ObjName";

	if ( $value == $Default ){
		$retHtml = "<input name=\"$ObjName\" value=\"$value\" type=\"checkbox\" checked>\n";
	}else{
		$retHtml = "<input name=\"$ObjName\" value=\"$value\" type=\"checkbox\">\n";
	}
	return	$retHtml;
}
// ------------------------------------------------------------------------------
// ランダムなパスワードを生成する
// ------------------------------------------------------------------------------
function swFunc_CreatePassword($Length = 10){
    $Min = 48;
    $Max = 122;
    $Password = '';
    while (strlen($Password) < $Length) {
        $char = chr(mt_rand($Min, $Max));
        if (preg_match('#[2-9a-np-zA-HJ-NP-Z]#', $char)) {
            $Password .= $char;
        }
    }
    return $Password;
}

/**
 * PHPの「mb_convert_kana」風文字列置換え
 *
 * 入力文字列の揺らぎの修正を主な目的としていますので「mb_convert_kana」とは
 * 異なります。
 *
 * オプション文字列の先頭から変換関数を順番に実行していきます。
 *
 * 再変換時に元の文字列に戻る保障はありません。
 * 文字数が変わる可能性があります。
 * 「濁点」「半濁点」の揺らぎの修正をデフォルトで行います。
 * 「ゕゖ」を「ヵヶ」にデフォルトで変換します。
 * 「水平タブ(HT)」をスペース4文字に展開します。
 * 「改行(LF)」以外の制御文字を空文字に変換します。
 * 半角カタカナは全角カタカナに置き換えられます。
 *
 * オプションの相違点
 * 「h」「H」「K」「k」は存在しません。半角カタカナはデフォルトで
 * 全角カタカナに変換されます。
 * 「V」は「う濁」から「は濁」への変換となります。
 *
 * ひらがなに無いカタカナは変換しません。
 * 「ㇰ」「ㇱ」「ㇲ」「ㇳ」「ㇴ」「ㇵ」「ㇶ」「ㇷ」
 * 「ㇸ」「ㇹ」「ㇺ」「ㇻ」「ㇼ」「ㇽ」「ㇾ」「ㇿ」
 *
 * 合成できなかった濁点・半濁点は単独の濁点(U+309B)・半濁点(U+309C)になります。
 * NFKC正規化では「U+3099（゙）」「U+309A（゚）」ですがフォントによっては
 * うまく表示されないための対処です。
 * 「mb_convert_kana」と同じ処理になります。
 *
 * http://hydrocul.github.io/wiki/blog/2014/1127-unicode-nfkd-mb-convert-kana.html
 *
 * オプションで使用する文字列
 * r: 「全角」英字を「半角」に変換します。
 * R: 「半角」英字を「全角」に変換します。
 * n: 「全角」数字を「半角」に変換します。
 * N: 「半角」数字を「全角」に変換します。
 * a: 「全角」英数字記号を「半角」に変換します。
 * A: 「半角」英数字記号を「全角」に変換します。
 * s: 「全角」スペースを「半角」に変換します（U+3000 -> U+0020）。
 * S: 「半角」スペースを「全角」に変換します（U+0020 -> U+3000）。
 * c: 「全角カタカナ」を「全角ひらがな」に変換します。
 * C: 「全角ひらがな」を「全角カタカナ」に変換します。
 * v: 「う濁」を「は濁」に変換します。
 * V: 「ウ濁」を「ハ濁」に変換します。
 * Q: 「半角」クォーテーション、「半角」アポストロフィを「全角」に変換します。
 * q: 「全角」クォーテーション、「全角」アポストロフィを「半角」に変換します。
 * B: 「半角」バックスラッシュを「全角」に変換します。
 * b: 「全角」バックスラッシュを「半角」に変換します。
 * T: 「半角」チルダを「全角」にチルダ変換します。
 * t: 「全角」チルダを「半角」チルダに変換します。
 * W: 全角「波ダッシュ」を全角「チルダ」に変換します。
 * w: 全角「チルダ」を全角「波ダッシュ」に変換します。
 * P: 「ハイフン、ダッシュ、マイナス」を「全角ハイフンマイナス」に変換します。（U+FF0D）
 * p: 「ハイフン、ダッシュ、マイナス」を「半角ハイフンマイナス」に変換します。（U+002D）
 * U: 「U+0021」～「U+007E」以外の「半角」記号を「全角」記号に変換します。
 * u: 「U+0021」～「U+007E」以外の「全角」記号を「半角」記号に変換します。
 * X: 「カッコ付き文字」を「半角括弧と中の文字」に展開します。
 * Y: 集合文字を展開します。（単位文字以外）
 * Z: 小字形文字を大文字に変換します。（U+FE50～U+FE6B）
 *
 * @param String $str 変換する文字列
 * @param String $opt 変換オプション
 *
 * @return String 変換された文字列
 */
function swFunc_ConvertKana($str = '', $opt = ''){
    // 変換する文字・オプションが文字列でない場合はそのまま返す
    if (!is_string($str) or ! is_string($opt)) {
        return $str;
    }

    /** ------------------------------------------------------------------------
     * ここから文字の揺らぎを修正する初期化関数です。
     * ---------------------------------------------------------------------- */
    $init = function() use(&$str) {
        // 「水平タブ(HT)」をスペース4文字に展開します。
        // 「ゕゖ」を「ヵヶ」に変換します。
        // 「U+3099（゙）」「U+309A（゚）」を単独の濁点
        // 「U+309B（゛）」「U+309C（゜）」に変換します。
        $src = array("\t", '゙', '゚', 'ゕ', 'ゖ');
        $rep = array('    ', '゛', '゜', 'ヵ', 'ヶ');
        $str = str_replace($src, $rep, $str);

        // 半角カタカナを全角カタカナに変換します。
        $str = mb_convert_kana($str, 'KV');

        // 「改行(LF)」以外の制御文字を空文字に変換します。
        $str = preg_replace('/[\x00-\x09\x0b-\x1f\x7f-\x9f]/u', '', $str);
        // unicodoの制御文字を空文字に変換します。
        $decoded = json_decode(
                        '["' .
                        '\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007' .
                        '\u2008\u2009\u200A\u200B\u200C\u200D\u200E\u200F' .
                        '\u2028\u2029\u202A\u202B\u202C\u202D\u202E' .
                        '\u2060' .
                        '\u206A\u206B\u206C\u206D\u206E\u206F' .
                        '\uFFF9\uFFFA\uFFFB' .
                        '"]', true)[0];
        $str = str_replace($decoded, '', $str);

        // 濁点・半濁点付きの文字を一文字に変換します。
        //
        // 「ゔ」は「う゛」に展開されます。
        // 「わ゛」は「う゛ぁ」に変換されます。
        // 「ゐ゛」は「う゛ぃ」に変換されます。
        // 「ゑ゛」は「う゛ぇ」に変換されます。
        // 「を゛」は「う゛ぉ」に変換されます。
        // 「ヷ」「ワ゛」は「ヴァ」に展開されます。
        // 「ヸ」「ヰ゛」は「ヴィ」に展開されます。
        // 「ヹ」「ヱ゛」は「ヴェ」に展開されます。
        // 「ヺ」「ヲ゛」は「ヴォ」に展開されます。
        $multi = array(
            'か゛', 'き゛', 'く゛', 'け゛', 'こ゛',
            'さ゛', 'し゛', 'す゛', 'せ゛', 'そ゛',
            'た゛', 'ち゛', 'つ゛', 'て゛', 'と゛',
            'は゛', 'ひ゛', 'ふ゛', 'へ゛', 'ほ゛',
            'は゜', 'ひ゜', 'ふ゜', 'へ゜', 'ほ゜',
            'ゔ', 'ゝ゛',
            'わ゛', 'ゐ゛', 'ゑ゛', 'を゛',
            'カ゛', 'キ゛', 'ク゛', 'ケ゛', 'コ゛',
            'サ゛', 'シ゛', 'ス゛', 'セ゛', 'ソ゛',
            'タ゛', 'チ゛', 'ツ゛', 'テ゛', 'ト゛',
            'ハ゛', 'ヒ゛', 'フ゛', 'ヘ゛', 'ホ゛',
            'ハ゜', 'ヒ゜', 'フ゜', 'ヘ゜', 'ホ゜',
            'ウ゛', 'ヽ゛',
            'ワ゛', 'ヰ゛', 'ヱ゛', 'ヲ゛',
            'ヷ', 'ヸ', 'ヹ', 'ヺ'
        );
        $single = array(
            'が', 'ぎ', 'ぐ', 'げ', 'ご',
            'ざ', 'じ', 'ず', 'ぜ', 'ぞ',
            'だ', 'ぢ', 'づ', 'で', 'ど',
            'ば', 'び', 'ぶ', 'べ', 'ぼ',
            'ぱ', 'ぴ', 'ぷ', 'ぺ', 'ぽ',
            'う゛', 'ゞ',
            'う゛ぁ', 'う゛ぃ', 'う゛ぇ', 'う゛ぉ',
            'ガ', 'ギ', 'グ', 'ゲ', 'ゴ',
            'ザ', 'ジ', 'ズ', 'ゼ', 'ゾ',
            'ダ', 'ヂ', 'ヅ', 'デ', 'ド',
            'バ', 'ビ', 'ブ', 'ベ', 'ボ',
            'パ', 'ピ', 'プ', 'ペ', 'ポ',
            'ヴ', 'ヾ',
            'ヴァ', 'ヴィ', 'ヴェ', 'ヴォ',
            'ヴァ', 'ヴィ', 'ヴェ', 'ヴォ'
        );

        $str = str_replace($multi, $single, $str);
    };

    /** ------------------------------------------------------------------------
     * ここからオプションの文字により変換を行う関数です。
     * ---------------------------------------------------------------------- */
    $convert = function($s) use(&$str) {
        switch ($s) {
            // r: 「全角」英字を「半角」に変換します。
            case 'r':
                $str = mb_convert_kana($str, 'r');
                break;

            // R: 「半角」英字を「全角」に変換します。
            case 'R':
                $str = mb_convert_kana($str, 'R');
                break;

            // n: 「全角」数字を「半角」に変換します。
            case 'n':
                $str = mb_convert_kana($str, 'n');
                break;

            // N: 「半角」数字を「全角」に変換します。
            case 'N':
                $str = mb_convert_kana($str, 'N');
                break;

            // a: 「全角」英数字記号を「半角」に変換します。
            //
            // "a", "A" オプションに含まれる文字は、
            // U+0022, U+0027, U+005C, U+007Eを除く（" ' \ ~ ）
            // U+0021 - U+007E の範囲です。
            case 'a':
                $str = mb_convert_kana($str, 'a');
                break;

            // A: 「半角」英数字記号を「全角」に変換します 。
            //
            // "a", "A" オプションに含まれる文字は、
            // U+0022, U+0027, U+005C, U+007Eを除く（" ' \ ~ ）
            // U+0021 - U+007E の範囲です。
            case 'A':
                $str = mb_convert_kana($str, 'A');
                break;

            // s: 「全角」スペースを「半角」に変換します（U+3000 -> U+0020）。
            case 's':
                $str = mb_convert_kana($str, 's');
                break;

            // S: 「半角」スペースを「全角」に変換します（U+0020 -> U+3000）。
            case 'S':
                $str = mb_convert_kana($str, 'S');
                break;

            // c: 「全角カタカナ」を「全角ひらがな」に変換します。
            //
            // 「ヽヾ」は「ゝゞ」に変換されます。
            // 「ヴ」は「う゛」に展開されます。
            // 「ヶ」は変換されません。（変換先が「か」「が」「こ」の複数あるため）
            // 「ヵ」は「か」に変換されます。
            // http://www.wikiwand.com/ja/%E6%8D%A8%E3%81%A6%E4%BB%AE%E5%90%8D
            case 'c':
                $str = mb_convert_kana($str, 'c');
                $kana = array('ヴ', 'ヵ', 'ヽ', 'ヾ');
                $hira = array('う゛', 'か', 'ゝ', 'ゞ');
                $str = str_replace($kana, $hira, $str);
                break;

            // C: 「全角ひらがな」を「全角カタカナ」に変換します。
            //
            // 「ゝゞ」は「ヽヾ」に変換されます。
            // 「う゛」は「ヴ」に結合されます。
            case 'C':
                $str = mb_convert_kana($str, 'C');
                $hira = array('ウ゛', 'ゝ', 'ゞ');
                $kana = array('ヴ', 'ヽ', 'ヾ');
                $str = str_replace($hira, $kana, $str);
                break;

            // v: 「う濁」を「は濁」に変換します。
            //
            // 「う゛ぁ」「う゛ぃ」「う゛」「う゛ぇ」「う゛ぉ」を
            // 「ば」「び」「ぶ」「べ」「ぼ」に変換します。
            case 'v':
                $udaku = array(
                    'う゛ぁ', 'う゛ぃ', 'う゛ぇ', 'う゛ぉ', 'う゛',
                    'ゔぁ', 'ゔぃ', 'ゔぇ', 'ゔぉ', 'ゔ'
                );
                $hadaku = array(
                    'ば', 'び', 'べ', 'ぼ', 'ぶ',
                    'ば', 'び', 'べ', 'ぼ', 'ぶ'
                );
                $str = str_replace($udaku, $hadaku, $str);
                break;

            // V: 「ウ濁」を「ハ濁」に変換します。
            //
            // 「ヴァ」「ヴィ」「ヴ」「ヴェ」「ヴォ」を
            // 「バ」「ビ」「ブ」「ベ」「ボ」に変換します。
            case 'V':
                $udaku = array(
                    'ウ゛ァ', 'ウ゛ィ', 'ウ゛ェ', 'ウ゛ォ', 'ウ゛',
                    'ヴァ', 'ヴィ', 'ヴェ', 'ヴォ', 'ヴ'
                );
                $hadaku = array(
                    'バ', 'ビ', 'ベ', 'ボ', 'ブ',
                    'バ', 'ビ', 'ベ', 'ボ', 'ブ'
                );
                $str = str_replace($udaku, $hadaku, $str);
                break;

            // Q: 半角クォーテーション、半角アポストロフィを全角に変換します。
            case 'Q':
                $han = array('"', "'");
                $zen = array('＂', '＇');
                $str = str_replace($han, $zen, $str);
                break;

            // q: 全角クォーテーション、全角アポストロフィを半角に変換します。
            case 'q':
                $han = array('"', "'");
                $zen = array('＂', '＇');
                $str = str_replace($zen, $han, $str);
                break;

            // B: 半角バックスラッシュを全角に変換します。
            case 'B':
                $han = "\\";
                $zen = '＼';
                $str = str_replace($han, $zen, $str);
                break;

            // b: 全角バックスラッシュを半角に変換します。
            case 'b':
                $han = "\\";
                $zen = '＼';
                $str = str_replace($zen, $han, $str);
                break;

            // T: 半角チルダを全角にチルダ変換します。
            case 'T':
                $han = '~';
                $zen = '～';
                $str = str_replace($han, $zen, $str);
                break;

            // t: 全角チルダを半角チルダに変換します。
            case 't':
                $han = '~';
                $zen = '～';
                $str = str_replace($zen, $han, $str);
                break;

            // W: 全角波ダッシュを全角チルダに変換します。
            case 'W':
                $nami = '〜';
                $tilde = '～';
                $str = str_replace($nami, $tilde, $str);
                break;

            // w: 全角チルダを全角波ダッシュに変換します。
            case 'w':
                $nami = '〜';
                $tilde = '～';
                $str = str_replace($tilde, $nami, $str);
                break;

            // P: ハイフン、ダッシュ、マイナスを全角ハイフンマイナスに変換します。（U+FF0D）
            //    英数記号の後ろにある全角・半角長音符も含む
            //
            // http://hydrocul.github.io/wiki/blog/2014/1101-hyphen-minus-wave-tilde.html
            //    「U+002D」半角ハイフンマイナス
            //    「U+FE63」小さいハイフンマイナス。NFKD/NFKC正規化で U+002D
            //    「U+FF0D」全角ハイフンマイナス
            //    「U+2212」「U+207B」「U+208B」マイナス
            //    「U+2010」「U+2011」ハイフン
            //    「U+2012」～「U+2015」「U+FE58」ダッシュ
            case 'P':
                $phyhen = array(
                    '-', '﹣', '－', '−', '⁻', '₋',
                    '‐', '‑', '‒', '–', '—', '―', '﹘'
                );
                $change = '－';
                $str = str_replace($phyhen, $change, $str);
                $str = preg_replace('/([!-~！-～])(ー|ｰ)/u', '$1' . $change, $str);
                break;

            // p: ハイフン、ダッシュ、マイナスを半角ハイフンマイナスに変換します。（U+002D）
            //    英数記号の後ろにある全角・半角長音符も含む
            //
            // http://hydrocul.github.io/wiki/blog/2014/1101-hyphen-minus-wave-tilde.html
            //    「U+002D」半角ハイフンマイナス
            //    「U+FE63」小さいハイフンマイナス。NFKD/NFKC正規化で U+002D
            //    「U+FF0D」全角ハイフンマイナス
            //    「U+2212」「U+207B」「U+208B」マイナス
            //    「U+2010」「U+2011」ハイフン
            //    「U+2012」～「U+2015」「U+FE58」ダッシュ
            case 'p':
                $phyhen = array(
                    '-', '﹣', '－', '−', '⁻', '₋',
                    '‐', '‑', '‒', '–', '—', '―', '﹘'
                );
                $change = '-';
                $str = str_replace($phyhen, $change, $str);
                $str = preg_replace('/([!-~！-～])(ー|ｰ)/u', '$1' . $change, $str);
                break;

            // U: 「U+0021」～「U+007E」以外の「半角」記号を「全角」記号に変換します。
            //
            // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/uff00.html
            case 'U':
                $han = array(
                    '⦅', '⦆', '¢', '£', '¬', '¯', '¦', '¥',
                    '₩', '￨', '￩', '￪', '￫', '￬', '￭', '￮'
                );
                $zen = array(
                    '｟', '｠', '￠', '￡', '￢', '￣', '￤', '￥',
                    '￦', '│', '←', '↑', '→', '↓', '■', '○'
                );
                $str = str_replace($han, $zen, $str);
                break;

            // u: 「U+0021」～「U+007E」以外の「全角」記号を「半角」記号に変換します。
            //
            // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/uff00.html
            case 'u':
                $han = array(
                    '⦅', '⦆', '¢', '£', '¬', '¯', '¦', '¥',
                    '₩', '￨', '￩', '￪', '￫', '￬', '￭', '￮'
                );
                $zen = array(
                    '｟', '｠', '￠', '￡', '￢', '￣', '￤', '￥',
                    '￦', '│', '←', '↑', '→', '↓', '■', '○'
                );
                $str = str_replace($zen, $han, $str);
                break;

            // X: カッコ付き文字を半角括弧と中の文字に展開します。
            //
            // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/u2460.html
            // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/u3200.html
            case 'X':
                $single = array(
                    '⑴', '⑵', '⑶', '⑷', '⑸',
                    '⑹', '⑺', '⑻', '⑼', '⑽',
                    '⑾', '⑿', '⒀', '⒁', '⒂',
                    '⒃', '⒄', '⒅', '⒆', '⒇',
                    '⒜', '⒝', '⒞', '⒟', '⒠', '⒡', '⒢', '⒣',
                    '⒤', '⒥', '⒦', '⒧', '⒨', '⒩', '⒪', '⒫',
                    '⒬', '⒭', '⒮', '⒯', '⒰', '⒱', '⒲', '⒳',
                    '⒴', '⒵',
                    '㈠', '㈡', '㈢', '㈣', '㈤',
                    '㈥', '㈦', '㈧', '㈨', '㈩',
                    '㈪', '㈫', '㈬', '㈭', '㈮', '㈯', '㈰',
                    '㈱', '㈲', '㈳', '㈴', '㈵', '㈶', '㈷',
                    '㈸', '㈹', '㈺', '㈻', '㈼', '㈽', '㈾',
                    '㈿', '㉀', '㉁', '㉂', '㉃'
                );
                $multi = array(
                    '(1)', '(2)', '(3)', '(4)', '(5)',
                    '(6)', '(7)', '(8)', '(9)', '(10)',
                    '(11)', '(12)', '(13)', '(14)', '(15)',
                    '(16)', '(17)', '(18)', '(19)', '(20)',
                    '(a)', '(b)', '(c)', '(d)', '(e)', '(f)', '(g)', '(h)',
                    '(i)', '(j)', '(k)', '(l)', '(m)', '(n)', '(o)', '(p)',
                    '(q)', '(r)', '(s)', '(t)', '(u)', '(v)', '(w)', '(x)',
                    '(y)', '(z)',
                    '(一)', '(二)', '(三)', '(四)', '(五)',
                    '(六)', '(七)', '(八)', '(九)', '(十)',
                    '(月)', '(火)', '(水)', '(木)', '(金)', '(土)', '(日)',
                    '(株)', '(有)', '(社)', '(名)', '(特)', '(財)', '(祝)',
                    '(労)', '(代)', '(呼)', '(学)', '(監)', '(企)', '(資)',
                    '(協)', '(祭)', '(休)', '(自)', '(至)'
                );
                $str = str_replace($single, $multi, $str);
                break;

            // Y: 集合文字を展開します。（単位文字以外）
            //
            // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/u2460.html
            // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/u3200.html
            // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/u3300.html
            case 'Y':
                $single = array(
                    '㌀', '㌁', '㌂', '㌃', '㌄', '㌅',
                    '㌆', '㌇', '㌈', '㌉', '㌊', '㌋',
                    '㌌', '㌍', '㌎', '㌏', '㌐', '㌑', '㌒',
                    '㌓', '㌔', '㌕', '㌖', '㌗', '㌘',
                    '㌙', '㌚', '㌛', '㌜', '㌝', '㌞',
                    '㌟', '㌠', '㌡', '㌢', '㌣', '㌤',
                    '㌥', '㌦', '㌧', '㌨', '㌩', '㌪', '㌫',
                    '㌬', '㌭', '㌮', '㌯', '㌰', '㌱', '㌲',
                    '㌳', '㌴', '㌵', '㌶', '㌷', '㌸',
                    '㌹', '㌺', '㌻', '㌼', '㌽', '㌾', '㌿',
                    '㍀', '㍁', '㍂', '㍃', '㍄', '㍅', '㍆',
                    '㍇', '㍈', '㍉', '㍊', '㍋', '㍌',
                    '㍍', '㍎', '㍏', '㍐', '㍑', '㍒', '㍓',
                    '㍔', '㍕', '㍖', '㍗',
                    '㍿', '㍻', '㍼', '㍽', '㍾',
                    '㋀', '㋁', '㋂', '㋃', '㋄', '㋅',
                    '㋆', '㋇', '㋈', '㋉', '㋊', '㋋',
                    '㏠', '㏡', '㏢', '㏣', '㏤',
                    '㏥', '㏦', '㏧', '㏨', '㏩',
                    '㏪', '㏫', '㏬', '㏭', '㏮',
                    '㏯', '㏰', '㏱', '㏲', '㏳',
                    '㏴', '㏵', '㏶', '㏷', '㏸',
                    '㏹', '㏺', '㏻', '㏼', '㏽', '㏾',
                    '㍘', '㍙', '㍚', '㍛', '㍜', '㍝',
                    '㍞', '㍟', '㍠', '㍡', '㍢',
                    '㍣', '㍤', '㍥', '㍦', '㍧',
                    '㍨', '㍩', '㍪', '㍫', '㍬',
                    '㍭', '㍮', '㍯', '㍰',
                    '⒈', '⒉', '⒊', '⒋', '⒌', '⒍', '⒎', '⒏', '⒐', '⒑',
                    '⒒', '⒓', '⒔', '⒕', '⒖', '⒗', '⒘', '⒙', '⒚', '⒛',
                    '№', '℡', '㏍', '㏇', '㏂', '㏘'
                );
                $multi = array(
                    'アパート', 'アルファ', 'アンペア', 'アール', 'イニング', 'インチ',
                    'ウォン', 'エスクード', 'エーカー', 'オンス', 'オーム', 'カイリ',
                    'カラット', 'カロリー', 'ガロン', 'ガンマ', 'ギガ', 'ギニー', 'キュリー',
                    'ギルダー', 'キロ', 'キログラム', 'キロメートル', 'キロワット', 'グラム',
                    'グラムトン', 'クルゼイロ', 'クローネ', 'ケース', 'コルナ', 'コーポ',
                    'サイクル', 'サンチーム', 'シリング', 'センチ', 'セント', 'ダース',
                    'デシ', 'ドル', 'トン', 'ナノ', 'ノット', 'ハイツ', 'パーセント',
                    'パーツ', 'バーレル', 'ピアストル', 'ピクル', 'ピコ', 'ビル', 'ファラッド',
                    'フィート', 'ブッシェル', 'フラン', 'ヘクタール', 'ペソ', 'ペニヒ',
                    'ヘルツ', 'ペンス', 'ページ', 'ベータ', 'ポイント', 'ボルト', 'ホン',
                    'ポンド', 'ホール', 'ホーン', 'マイクロ', 'マイル', 'マッハ', 'マルク',
                    'マンション', 'ミクロン', 'ミリ', 'ミリバール', 'メガ', 'メガトン',
                    'メートル', 'ヤード', 'ヤール', 'ユアン', 'リットル', 'リラ', 'ルピー',
                    'ルーブル', 'レム', 'レントゲン', 'ワット',
                    '株式会社', '平成', '昭和', '大正', '明治',
                    '1月', '2月', '3月', '4月', '5月', '6月',
                    '7月', '8月', '9月', '10月', '11月', '12月',
                    '1日', '2日', '3日', '4日', '5日',
                    '6日', '7日', '8日', '9日', '10日',
                    '11日', '12日', '13日', '14日', '15日',
                    '16日', '17日', '18日', '19日', '20日',
                    '21日', '22日', '23日', '24日', '25日',
                    '26日', '27日', '28日', '29日', '30日', '31日',
                    '0点', '1点', '2点', '3点', '4点', '5点',
                    '6点', '7点', '8点', '9点', '10点',
                    '11点', '12点', '13点', '14点', '15点',
                    '16点', '17点', '18点', '19点', '20点',
                    '21点', '22点', '23点', '24点',
                    '1.', '2.', '3.', '4.', '5.', '6.', '7.', '8.', '9.', '10.',
                    '11.', '12.', '13.', '14.', '15.', '16.', '17.', '18.', '19.',
                    '20.',
                    'No.', 'TEL', 'K.K.', 'Co.', 'a.m.', 'p.m.'
                );
                $str = str_replace($single, $multi, $str);
                break;

            // Z: 小字形文字を大文字に変換します。（U+FE50～U+FE6B）
            // 「﹐﹑﹒﹔﹕﹖﹗﹘﹙﹚﹛﹜﹝﹞﹟﹠﹡﹢﹣﹤﹥﹦﹨﹩﹪﹫」
            //
            // 「U+FF58」は「U+2014」へマッピングされていますが、揺らぎの訂正のため
            // 「U+002D（半角ハイフンマイナス）」に変換します。
            //
            // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/ufe50.html
            case 'Z':
                $small = array(
                    '﹐', '﹑', '﹒', '﹔', '﹕', '﹖', '﹗', '﹘', '﹙', '﹚',
                    '﹛', '﹜', '﹝', '﹞', '﹟', '﹠', '﹡', '﹢', '﹣',
                    '﹤', '﹥', '﹦', '﹨', '﹩', '﹪', '﹫'
                );
                $big = array(
                    ',', '、', '.', ';', ':', '?', '!', '-', '(', ')',
                    '{', '}', '〔', '〕', '#', '&', '*', '+', '-',
                    '<', '>', '=', "\\", '$', '%', '@'
                );
                $str = str_replace($small, $big, $str);
                break;
            default :
                break;
        }
    };

    // 文字列の初期化（揺らぎの訂正）を行ないます
    $init();
    // オプション文字列を分解して一文字ごとに$convertを実行します
    array_map($convert, str_split($opt));

    return $str;
}

// ------------------------------------------------------------------------------
// DEBUG ECHO
// ------------------------------------------------------------------------------
function swFunc_Debug($ObjName){
	if(DEBUG_MODE){
		echo "$ObjName<br>";
	}
}
//-------------------------------------------------------------------------------------------------------
?>
<?php
// ------------------------------------------------------------------------------
//	台詞を「」で囲むか（ユーザーオプション SW_USER_OPTION_SETTING.USE_KAGIKAKKO）2026-09 追加
//		各ｽｸﾘﾌﾟﾄは最初に swFunc_LoadKagikakkoOption($mySqlConnObj,$scenarioId) を呼んで
//		$GLOBALS['swUseKagikakko'] を設定する（ｼﾅﾘｵの所有者の設定を見る。共有閲覧でも使える）。
//		未設定・未登録なら「囲む」。
// ------------------------------------------------------------------------------
function swFunc_LoadKagikakkoOption($mySqlConnObj,$scenarioId){
	$use = 1;
	if($scenarioId != ''){
		$strSQL = <<<END_OF_SQL
		SELECT O.USE_KAGIKAKKO
			FROM SW_SCENARIO S
			LEFT JOIN SW_USER_OPTION_SETTING O ON O.USER_ID = S.USER_ID
			WHERE S.SCENARIO_ID = :ScenarioId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->bindParam(':ScenarioId', $scenarioId, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row && $row['USE_KAGIKAKKO'] !== null){
			$use = (int)$row['USE_KAGIKAKKO'];
		}
	}
	$GLOBALS['swUseKagikakko'] = $use;
	return $use;
}
//	「」で囲む（ｵﾌﾟｼｮﾝが「囲まない」ならそのまま返す）
function swFunc_Kagikakko($str){
	if(isset($GLOBALS['swUseKagikakko']) && (int)$GLOBALS['swUseKagikakko'] === 0){
		return $str;
	}
	return '「'.$str.'」';
}
//	最後の「。」を落として「」で囲む（ｵﾌﾟｼｮﾝが「囲まない」なら「。」も残してそのまま返す）
function swFunc_KagikakkoMaru($str){
	if(isset($GLOBALS['swUseKagikakko']) && (int)$GLOBALS['swUseKagikakko'] === 0){
		return $str;
	}
	return '「'.swFunc_RemoveLastStr($str,'。').'」';
}
?>
