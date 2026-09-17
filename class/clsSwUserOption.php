<?php
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//     個別設定 ﾃﾞｰﾀ管理ｸﾗｽ
//     clsSwUserOption
// -----------------------------------------------------------
class clsSwUserOption{
	var $UserOptionId;                        //USER_OPTION_ID
	var $UserId;                          //USER_ID
	var $UserOptionStyleId;               //スタイルID
	var $UserOptionStyleOrderNo;          //並び順
	var $UserOptionStyleName;             //スタイル名
	var $UserOptionStyleFontSize;         //フォントサイズ
	var $UserOptionStyleColor;            //文字色
	var $UserOptionStyleIndent;           //字下げ数
	var $UserOptionStyleStr;              //省略文字
	var $UserOptionStyleWord;             //台詞
// ｺﾝｽﾄﾗｸﾀ
    function clsfncSwUserOption(){
    }
// ﾌﾟﾛﾊﾟﾃｨ
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserOptionId
//    USER_OPTION_ID を返す
// --------------------------------------
	function clsSwUserOptionGetUserOptionId(){
		return $this->UserOptionId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserOptionId
//    USER_OPTION_ID を設定する
// --------------------------------------
	function clsSwUserOptionSetUserOptionId($valUserOptionId){
		$this->UserOptionId = $valUserOptionId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserId
//    USER_ID を返す
// --------------------------------------
	function clsSwUserOptionGetUserId(){
		return $this->UserId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserId
//    USER_ID を設定する
// --------------------------------------
	function clsSwUserOptionSetUserId($valUserId){
		$this->UserId = $valUserId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserOptionStyleId
//    スタイルID を返す
// --------------------------------------
	function clsSwUserOptionGetUserOptionStyleId(){
		return $this->UserOptionStyleId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserOptionStyleId
//    スタイルID を設定する
// --------------------------------------
	function clsSwUserOptionSetUserOptionStyleId($valUserOptionStyleId){
		$this->UserOptionStyleId = $valUserOptionStyleId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserOptionStyleOrderNo
//    並び順 を返す
// --------------------------------------
	function clsSwUserOptionGetUserOptionStyleOrderNo(){
		return $this->UserOptionStyleOrderNo;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserOptionStyleOrderNo
//    並び順 を設定する
// --------------------------------------
	function clsSwUserOptionSetUserOptionStyleOrderNo($valUserOptionStyleOrderNo){
		$this->UserOptionStyleOrderNo = $valUserOptionStyleOrderNo;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserOptionStyleName
//    スタイル名 を返す
// --------------------------------------
	function clsSwUserOptionGetUserOptionStyleName(){
		return $this->UserOptionStyleName;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserOptionStyleName
//    スタイル名 を設定する
// --------------------------------------
	function clsSwUserOptionSetUserOptionStyleName($valUserOptionStyleName){
		$this->UserOptionStyleName = $valUserOptionStyleName;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserOptionStyleFontSize
//    フォントサイズ を返す
// --------------------------------------
	function clsSwUserOptionGetUserOptionStyleFontSize(){
		return $this->UserOptionStyleFontSize;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserOptionStyleFontSize
//    フォントサイズ を設定する
// --------------------------------------
	function clsSwUserOptionSetUserOptionStyleFontSize($valUserOptionStyleFontSize){
		$this->UserOptionStyleFontSize = $valUserOptionStyleFontSize;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserOptionStyleColor
//    文字色 を返す
// --------------------------------------
	function clsSwUserOptionGetUserOptionStyleColor(){
		return $this->UserOptionStyleColor;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserOptionStyleColor
//    文字色 を設定する
// --------------------------------------
	function clsSwUserOptionSetUserOptionStyleColor($valUserOptionStyleColor){
		$this->UserOptionStyleColor = $valUserOptionStyleColor;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserOptionStyleIndent
//    字下げ数 を返す
// --------------------------------------
	function clsSwUserOptionGetUserOptionStyleIndent(){
		return $this->UserOptionStyleIndent;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserOptionStyleIndent
//    字下げ数 を設定する
// --------------------------------------
	function clsSwUserOptionSetUserOptionStyleIndent($valUserOptionStyleIndent){
		$this->UserOptionStyleIndent = $valUserOptionStyleIndent;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserOptionStyleStr
//    省略文字 を返す
// --------------------------------------
	function clsSwUserOptionGetUserOptionStyleStr(){
		return $this->UserOptionStyleStr;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserOptionStyleStr
//    省略文字 を設定する
// --------------------------------------
	function clsSwUserOptionSetUserOptionStyleStr($valUserOptionStyleStr){
		$this->UserOptionStyleStr = $valUserOptionStyleStr;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserOptionStyleWord
//    台詞 を返す
// --------------------------------------
	function clsSwUserOptionGetUserOptionStyleWord(){
		return $this->UserOptionStyleWord;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserOptionStyleWord
//    台詞 を設定する
// --------------------------------------
	function clsSwUserOptionSetUserOptionStyleWord($valUserOptionStyleWord){
		$this->UserOptionStyleWord = $valUserOptionStyleWord;
	}
// -------------------------------------------------------------
//    ｸﾗｽ初期化
// -------------------------------------------------------------
	function clsSwUserOptionInit($mySqlConnObj,$valUserOptionId){
		//ﾌﾟﾛﾊﾟﾃｨの初期化
		$this->UserOptionId = '';                        //USER_OPTION_ID
		$this->UserId = '';                          //USER_ID
		$this->UserOptionStyleId = '';               //スタイルID
		$this->UserOptionStyleOrderNo = '';          //並び順
		$this->UserOptionStyleName = '';             //スタイル名
		$this->UserOptionStyleFontSize = '';         //フォントサイズ
		$this->UserOptionStyleColor = '';            //文字色
		$this->UserOptionStyleIndent = '';           //字下げ数
		$this->UserOptionStyleStr = '';              //省略文字
		$this->UserOptionStyleWord = '';             //台詞
		//DB から ﾃﾞｰﾀを取得しﾌﾟﾛﾊﾟﾃｨにｾｯﾄする
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER_OPTION
				WHERE USER_OPTION_ID = :UserOptionId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':UserOptionId', $valUserOptionId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$this->UserOptionId = $myRow['USER_OPTION_ID'];
			$this->UserId = $myRow['USER_ID'];
			$this->UserOptionStyleId = $myRow['USER_OPTION_STYLE_ID'];
			$this->UserOptionStyleOrderNo = $myRow['USER_OPTION_STYLE_ORDER_NO'];
			$this->UserOptionStyleName = $myRow['USER_OPTION_STYLE_NAME'];
			$this->UserOptionStyleFontSize = $myRow['USER_OPTION_STYLE_FONT_SIZE'];
			$this->UserOptionStyleColor = $myRow['USER_OPTION_STYLE_COLOR'];
			$this->UserOptionStyleIndent = $myRow['USER_OPTION_STYLE_INDENT'];
			$this->UserOptionStyleStr = $myRow['USER_OPTION_STYLE_STR'];
			$this->UserOptionStyleWord = $myRow['USER_OPTION_STYLE_WORD'];
		}//end while
		//件数を返す
		return	$myRowCnt;
    }//end function

// -------------------------------------------------------------
//    DB更新　INSERT
// -------------------------------------------------------------
	function clsSwUserOptionDbInsert($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valUserOptionId = $this->UserOptionId;
		$valUserId = $this->UserId;
		$valUserOptionStyleId = $this->UserOptionStyleId;
		$valUserOptionStyleOrderNo = $this->UserOptionStyleOrderNo;
		$valUserOptionStyleName = $this->UserOptionStyleName;
		$valUserOptionStyleFontSize = $this->UserOptionStyleFontSize;
		$valUserOptionStyleColor = $this->UserOptionStyleColor;
		$valUserOptionStyleIndent = $this->UserOptionStyleIndent;
		$valUserOptionStyleStr = $this->UserOptionStyleStr;
		$valUserOptionStyleWord = $this->UserOptionStyleWord;
		
		//INSERT SQL
		$strSQL = <<<END_OF_SQL

			INSERT INTO SW_USER_OPTION(
				  USER_ID
				, USER_OPTION_STYLE_ID
				, USER_OPTION_STYLE_ORDER_NO
				, USER_OPTION_STYLE_NAME
				, USER_OPTION_STYLE_FONT_SIZE
				, USER_OPTION_STYLE_COLOR
				, USER_OPTION_STYLE_INDENT
				, USER_OPTION_STYLE_STR
				, USER_OPTION_STYLE_WORD
			) values (
				  :UserId
				, :UserOptionStyleId
				, :UserOptionStyleOrderNo
				, :UserOptionStyleName
				, :UserOptionStyleFontSize
				, :UserOptionStyleColor
				, :UserOptionStyleIndent
				, :UserOptionStyleStr
				, :UserOptionStyleWord
			);
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータ設定
		$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
		$stmt->bindParam(':UserOptionStyleId', $valUserOptionStyleId, PDO::PARAM_INT);
		$stmt->bindParam(':UserOptionStyleOrderNo', $valUserOptionStyleOrderNo, PDO::PARAM_INT);
		$stmt->bindParam(':UserOptionStyleName', $valUserOptionStyleName, PDO::PARAM_STR);
		$stmt->bindParam(':UserOptionStyleFontSize', $valUserOptionStyleFontSize, PDO::PARAM_INT);
		$stmt->bindParam(':UserOptionStyleColor', $valUserOptionStyleColor, PDO::PARAM_STR);
		$stmt->bindParam(':UserOptionStyleIndent', $valUserOptionStyleIndent, PDO::PARAM_INT);
		$stmt->bindParam(':UserOptionStyleStr', $valUserOptionStyleStr, PDO::PARAM_STR);
		$stmt->bindParam(':UserOptionStyleWord', $valUserOptionStyleWord, PDO::PARAM_INT);
		//EXECUTE
		$stmt->execute();
		
		//AUTO_INCREMENT値取得
		$LastInsertId = $mySqlConnObj->lastInsertId();
		
		//AUTO_INCREMENT値を返す
		return $LastInsertId;

	}//end function

// -------------------------------------------------------------
//    DB更新　UPDATE
// -------------------------------------------------------------
	function clsSwUserOptionDbUpdate($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valUserOptionId = $this->UserOptionId;
		$valUserId = $this->UserId;
		$valUserOptionStyleId = $this->UserOptionStyleId;
		$valUserOptionStyleOrderNo = $this->UserOptionStyleOrderNo;
		$valUserOptionStyleName = $this->UserOptionStyleName;
		$valUserOptionStyleFontSize = $this->UserOptionStyleFontSize;
		$valUserOptionStyleColor = $this->UserOptionStyleColor;
		$valUserOptionStyleIndent = $this->UserOptionStyleIndent;
		$valUserOptionStyleStr = $this->UserOptionStyleStr;
		$valUserOptionStyleWord = $this->UserOptionStyleWord;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER_OPTION
				WHERE USER_OPTION_ID = :UserOptionId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':UserOptionId', $valUserOptionId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwUserOption ->> NOT ENTRY!");
		}else{
			//UPDATE SQL
			$strSQL = <<<END_OF_SQL

			UPDATE SW_USER_OPTION SET 
				  USER_ID = :UserId
				, USER_OPTION_STYLE_ID = :UserOptionStyleId
				, USER_OPTION_STYLE_ORDER_NO = :UserOptionStyleOrderNo
				, USER_OPTION_STYLE_NAME = :UserOptionStyleName
				, USER_OPTION_STYLE_FONT_SIZE = :UserOptionStyleFontSize
				, USER_OPTION_STYLE_COLOR = :UserOptionStyleColor
				, USER_OPTION_STYLE_INDENT = :UserOptionStyleIndent
				, USER_OPTION_STYLE_STR = :UserOptionStyleStr
				, USER_OPTION_STYLE_WORD = :UserOptionStyleWord
				WHERE USER_OPTION_ID = :UserOptionId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータ設定
			$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
			$stmt->bindParam(':UserOptionStyleId', $valUserOptionStyleId, PDO::PARAM_INT);
			$stmt->bindParam(':UserOptionStyleOrderNo', $valUserOptionStyleOrderNo, PDO::PARAM_INT);
			$stmt->bindParam(':UserOptionStyleName', $valUserOptionStyleName, PDO::PARAM_STR);
			$stmt->bindParam(':UserOptionStyleFontSize', $valUserOptionStyleFontSize, PDO::PARAM_INT);
			$stmt->bindParam(':UserOptionStyleColor', $valUserOptionStyleColor, PDO::PARAM_STR);
			$stmt->bindParam(':UserOptionStyleIndent', $valUserOptionStyleIndent, PDO::PARAM_INT);
			$stmt->bindParam(':UserOptionStyleStr', $valUserOptionStyleStr, PDO::PARAM_STR);
			$stmt->bindParam(':UserOptionStyleWord', $valUserOptionStyleWord, PDO::PARAM_INT);
			//パラメータ設定
			$stmt->bindParam(':UserOptionId', $valUserOptionId, PDO::PARAM_INT);
			//EXECUTE
			$stmt->execute();
		}//end if
	}//end function

// -------------------------------------------------------------
//    DB更新　DELETE
// -------------------------------------------------------------
	function clsSwUserOptionDbDelete($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valUserOptionId = $this->UserOptionId;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER_OPTION
				WHERE USER_OPTION_ID = :UserOptionId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':UserOptionId', $valUserOptionId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwUserOption ->> NOT ENTRY!");
		}else{
			//DELETE SQL
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_USER_OPTION
				WHERE USER_OPTION_ID = :UserOptionId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':UserOptionId', $valUserOptionId, PDO::PARAM_INT);
			$stmt->execute();
		}//end if
	}//end function
// -------------------------------------------------------------
//    スタイルの並び順を整理する
// -------------------------------------------------------------
	function fncAdjustUserOptionStyleOrderNo($mySqlConnObj,$valUserId){
		//並び順初期化
		$OrderNo = 0;
		//更新オブジェクトを準備する
		$strUpdSQL = <<<END_OF_SQL
			
			UPDATE SW_USER_OPTION SET
				USER_OPTION_STYLE_ORDER_NO = :UserOptionStyleOrderNo
				WHERE USER_OPTION_ID = :UserOptionId;
END_OF_SQL;
		$upd_stmt = $mySqlConnObj->prepare($strUpdSQL);
		//パラメータ設定
		$upd_stmt->bindParam(':UserOptionStyleOrderNo', $OrderNo, PDO::PARAM_INT);
		$upd_stmt->bindParam(':UserOptionId', $UserOptionId, PDO::PARAM_INT);

		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER_OPTION
				WHERE USER_ID = :UserId
				ORDER BY USER_OPTION_STYLE_ORDER_NO;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
		$stmt->execute();
		//更新する
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$OrderNo = $OrderNo + 100;
			$UserOptionId = $myRow['USER_OPTION_ID'];
			$UserOptionStyleOrderNo = $myRow['USER_OPTION_STYLE_ORDER_NO'];
			
			if( $UserOptionStyleOrderNo != $OrderNo){
				//EXECUTE
				$upd_stmt->execute();
			}
		}//end while
	}
// -------------------------------------------------------------
//    スタイルIDを設定
// -------------------------------------------------------------
	function fncGetNewUserOptionStyleId($mySqlConnObj,$valUserId){
		//スタイルを取得
		$strSQL = <<<END_OF_SQL

		SELECT 
			MAX(USER_OPTION_STYLE_ID)		AS	MAX_USER_OPTION_STYLE_ID
			FROM SW_USER_OPTION
				WHERE USER_ID = :UserId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
		$stmt->execute();
		$myRow = $stmt -> fetch(PDO::FETCH_ASSOC);
		$MaxUserOptionStyleId = $myRow['MAX_USER_OPTION_STYLE_ID'];
		$NewUserOptionStyleId = $MaxUserOptionStyleId + 1;
		return	$NewUserOptionStyleId;
	}

// -------------------------------------------------------------
//    USERのスタイルを配列化する
// -------------------------------------------------------------
	function fncGetUserOptionStyle($mySqlConnObj,$valUserId){
		//配列初期化
		$retArray = array();
		//スタイルを取得
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER_OPTION
				WHERE USER_ID = :UserId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
		$stmt->execute();
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$UserOptionId = $myRow['USER_OPTION_ID'];
			$UserId = $myRow['USER_ID'];
			$UserOptionStyleId = $myRow['USER_OPTION_STYLE_ID'];
			$UserOptionStyleOrderNo = $myRow['USER_OPTION_STYLE_ORDER_NO'];
			$UserOptionStyleName = $myRow['USER_OPTION_STYLE_NAME'];
			$UserOptionStyleFontSize = $myRow['USER_OPTION_STYLE_FONT_SIZE'];
			$UserOptionStyleColor = $myRow['USER_OPTION_STYLE_COLOR'];
			$UserOptionStyleIndent = $myRow['USER_OPTION_STYLE_INDENT'];
			$UserOptionStyleStr = $myRow['USER_OPTION_STYLE_STR'];
			$UserOptionStyleWord = $myRow['USER_OPTION_STYLE_WORD'];
			
			$csv = $UserOptionStyleFontSize.','.$UserOptionStyleColor.','.$UserOptionStyleIndent.','.$UserOptionStyleStr.','.$UserOptionStyleWord;
			$retArray[$UserOptionStyleId] = $csv;
		}
		return	$retArray;
	}
// ------------------------------------------------------------------------------
// DEFAULT SETTING
// ------------------------------------------------------------------------------
	function clsSwUserOptionSetDefault($mySqlConnObj,$valUserId){
			//DELETE SQL
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_USER_OPTION
				WHERE USER_ID = :UserId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
			$stmt->execute();


			//SW_SCENE COPY
			$strSQL = <<<END_OF_SQL

			INSERT INTO SW_USER_OPTION(
				  USER_ID
				, USER_OPTION_STYLE_ID
				, USER_OPTION_STYLE_ORDER_NO
				, USER_OPTION_STYLE_NAME
				, USER_OPTION_STYLE_FONT_SIZE
				, USER_OPTION_STYLE_COLOR
				, USER_OPTION_STYLE_INDENT
				, USER_OPTION_STYLE_STR
				, USER_OPTION_STYLE_WORD)
					SELECT
						  $valUserId
						, USER_OPTION_STYLE_ID
						, USER_OPTION_STYLE_ORDER_NO
						, USER_OPTION_STYLE_NAME
						, USER_OPTION_STYLE_FONT_SIZE
						, USER_OPTION_STYLE_COLOR
						, USER_OPTION_STYLE_INDENT
						, USER_OPTION_STYLE_STR
						, USER_OPTION_STYLE_WORD
					FROM SW_USER_OPTION
					WHERE USER_ID = '0';
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			$stmt->execute();
}

	// ------------------------------------------------------------------------------
	// java script alert
	// ------------------------------------------------------------------------------
	function fncAlert($AlertMsg){
		$strAlert = <<<END_OF_TEXT

			<script language="JavaScript">
				bootbox.alert("$AlertMsg",function() {
			});
			</script>
END_OF_TEXT;

		return $strAlert;
	}
	
} // end class
// -----------------------------------------------------------
?>