<?php
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//     ユーザーオプション設定 ﾃﾞｰﾀ管理ｸﾗｽ
//     clsSwUserOptionSetting
// -----------------------------------------------------------
class clsSwUserOptionSetting{
	var $UserId;                          //USER_ID
	var $CharacterLength;                 //キャラクタ部の文字数
	var $BodyLength;                      //シナリオ本文の文字数
	var $UseKagikakko;                    //台詞を「」で囲む(1=囲む,0=囲まない) 2026-09 追加
// ｺﾝｽﾄﾗｸﾀ
    function clsfncSwUserOptionSetting(){
    }
// ﾌﾟﾛﾊﾟﾃｨ
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserId
//    USER_ID を返す
// --------------------------------------
	function clsfncSwUserOptionSettingGetUserId(){
		return $this->UserId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserId
//    USER_ID を設定する
// --------------------------------------
	function clsSwUserOptionSettingSetUserId($valUserId){
		$this->UserId = $valUserId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get CharacterLength
//    キャラクタ部の文字数 を返す
// --------------------------------------
	function clsSwUserOptionSettingGetCharacterLength(){
		return $this->CharacterLength;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set CharacterLength
//    キャラクタ部の文字数 を設定する
// --------------------------------------
	function clsSwUserOptionSettingSetCharacterLength($valCharacterLength){
		$this->CharacterLength = $valCharacterLength;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get BodyLength
//    シナリオ本文の文字数 を返す
// --------------------------------------
	function clsSwUserOptionSettingGetBodyLength(){
		return $this->BodyLength;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set BodyLength
//    シナリオ本文の文字数 を設定する
// --------------------------------------
	function clsSwUserOptionSettingSetBodyLength($valBodyLength){
		$this->BodyLength = $valBodyLength;
	}
// ﾌﾟﾛﾊﾟﾃｨ Get/Set UseKagikakko（台詞を「」で囲む）
	function clsSwUserOptionSettingGetUseKagikakko(){
		return $this->UseKagikakko;
	}
	function clsSwUserOptionSettingSetUseKagikakko($valUseKagikakko){
		$this->UseKagikakko = ($valUseKagikakko == '0') ? 0 : 1;
	}
// -------------------------------------------------------------
//    ｸﾗｽ初期化
// -------------------------------------------------------------
	function clsSwUserOptionSettingInit($mySqlConnObj,$valUserId){
		//ﾌﾟﾛﾊﾟﾃｨの初期化
		$this->UserId = '';                          //USER_ID
		$this->CharacterLength = '';                 //キャラクタ部の文字数
		$this->BodyLength = '';                      //シナリオ本文の文字数
		$this->UseKagikakko = 1;                     //台詞を「」で囲む（既定: 囲む）
		//DB から ﾃﾞｰﾀを取得しﾌﾟﾛﾊﾟﾃｨにｾｯﾄする
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER_OPTION_SETTING
				WHERE USER_ID = :UserId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$this->UserId = $myRow['USER_ID'];
			$this->CharacterLength = $myRow['CHARACTER_LENGTH'];
			$this->BodyLength = $myRow['BODY_LENGTH'];
			$this->UseKagikakko = isset($myRow['USE_KAGIKAKKO']) ? (int)$myRow['USE_KAGIKAKKO'] : 1;
		}//end while
		
		return	$myRowCnt;
    }//end function

// -------------------------------------------------------------
//    DB更新　INSERT
// -------------------------------------------------------------
	function clsSwUserOptionSettingDbInsert($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valUserId = $this->UserId;
		$valCharacterLength = $this->CharacterLength;
		$valBodyLength = $this->BodyLength;
		$valUseKagikakko = ($this->UseKagikakko == 0) ? 0 : 1;
			//INSERT SQL
			$strSQL = <<<END_OF_SQL

			INSERT INTO SW_USER_OPTION_SETTING(
				  USER_ID
				, CHARACTER_LENGTH
				, BODY_LENGTH
				, USE_KAGIKAKKO
			) values (
				  :UserId
				, :CharacterLength
				, :BodyLength
				, :UseKagikakko
			);
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータ設定
		$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
		$stmt->bindParam(':CharacterLength', $valCharacterLength, PDO::PARAM_INT);
		$stmt->bindParam(':BodyLength', $valBodyLength, PDO::PARAM_INT);
		$stmt->bindParam(':UseKagikakko', $valUseKagikakko, PDO::PARAM_INT);
		//EXECUTE
		$stmt->execute();
	}//end function

// -------------------------------------------------------------
//    DB更新　UPDATE
// -------------------------------------------------------------
	function clsSwUserOptionSettingDbUpdate($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valUserId = $this->UserId;
		$valCharacterLength = $this->CharacterLength;
		$valBodyLength = $this->BodyLength;
		$valUseKagikakko = ($this->UseKagikakko == 0) ? 0 : 1;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER_OPTION_SETTING
				WHERE USER_ID = :UserId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwUserOptionSetting ->> NOT ENTRY!");
		}else{
			//UPDATE SQL
			$strSQL = <<<END_OF_SQL

			UPDATE SW_USER_OPTION_SETTING SET 
				  CHARACTER_LENGTH = :CharacterLength
				, BODY_LENGTH = :BodyLength
				, USE_KAGIKAKKO = :UseKagikakko
				WHERE USER_ID = :UserId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータ設定
			$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
			$stmt->bindParam(':CharacterLength', $valCharacterLength, PDO::PARAM_INT);
			$stmt->bindParam(':BodyLength', $valBodyLength, PDO::PARAM_INT);
			$stmt->bindParam(':UseKagikakko', $valUseKagikakko, PDO::PARAM_INT);
			//EXECUTE
			$stmt->execute();
		}//end if
	}//end function

// -------------------------------------------------------------
//    DB更新　DELETE
// -------------------------------------------------------------
	function clsSwUserOptionSettingDbDelete($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valUserId = $this->UserId;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER_OPTION_SETTING
				WHERE USER_ID = :UserId;
END_OF_SQL;

		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwUserOptionSetting ->> NOT ENTRY!");
		}else{
			//DELETE SQL
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_USER_OPTION_SETTING
				WHERE USER_ID = :UserId;
END_OF_SQL;

			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
			$stmt->execute();

		}//end if
	}//end function

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