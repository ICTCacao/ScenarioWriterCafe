<?php
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//     登場人物設定 ﾃﾞｰﾀ管理ｸﾗｽ
//     clsSwCharacter
// -----------------------------------------------------------
class clsSwCharacter{
	var $CharacterId;                     //CHARACTER_ID
	var $ScenarioId;                      //SCENARIO_ID
	var $CharacterOrderNo;                //並び順
	var $CharacterName;                   //登場人物名
	var $CharacterChara;                  //登場人物説明
// ｺﾝｽﾄﾗｸﾀ
    function clsfncSwCharacter(){
    }
// ﾌﾟﾛﾊﾟﾃｨ
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get CharacterId
//    CHARACTER_ID を返す
// --------------------------------------
	function clsSwCharacterGetCharacterId(){
		return $this->CharacterId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set CharacterId
//    CHARACTER_ID を設定する
// --------------------------------------
	function clsSwCharacterSetCharacterId($valCharacterId){
		$this->CharacterId = $valCharacterId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ScenarioId
//    SCENARIO_ID を返す
// --------------------------------------
	function clsSwCharacterGetScenarioId(){
		return $this->ScenarioId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ScenarioId
//    SCENARIO_ID を設定する
// --------------------------------------
	function clsSwCharacterSetScenarioId($valScenarioId){
		$this->ScenarioId = $valScenarioId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get CharacterOrderNo
//    並び順 を返す
// --------------------------------------
	function clsSwCharacterGetCharacterOrderNo(){
		return $this->CharacterOrderNo;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set CharacterOrderNo
//    並び順 を設定する
// --------------------------------------
	function clsSwCharacterSetCharacterOrderNo($valCharacterOrderNo){
		$this->CharacterOrderNo = $valCharacterOrderNo;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get CharacterName
//    登場人物名 を返す
// --------------------------------------
	function clsSwCharacterGetCharacterName(){
		return $this->CharacterName;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set CharacterName
//    登場人物名 を設定する
// --------------------------------------
	function clsSwCharacterSetCharacterName($valCharacterName){
		$this->CharacterName = $valCharacterName;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get CharacterChara
//    登場人物説明 を返す
// --------------------------------------
	function clsSwCharacterGetCharacterChara(){
		return $this->CharacterChara;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set CharacterChara
//    登場人物説明 を設定する
// --------------------------------------
	function clsSwCharacterSetCharacterChara($valCharacterChara){
		$this->CharacterChara = $valCharacterChara;
	}
// -------------------------------------------------------------
//    ｸﾗｽ初期化
// -------------------------------------------------------------
	function clsSwCharacterInit($mySqlConnObj,$valCharacterId){
		//ﾌﾟﾛﾊﾟﾃｨの初期化
		$this->CharacterId = '';                     //CHARACTER_ID
		$this->ScenarioId = '';                      //SCENARIO_ID
		$this->CharacterOrderNo = '';                //並び順
		$this->CharacterName = '';                   //登場人物名
		$this->CharacterChara = '';                  //登場人物説明
		
		//DB から ﾃﾞｰﾀを取得しﾌﾟﾛﾊﾟﾃｨにｾｯﾄする
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_CHARACTER
				WHERE CHARACTER_ID = :CharacterId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':CharacterId', $valCharacterId, PDO::PARAM_INT);
		$stmt->execute();
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$this->CharacterId = $myRow['CHARACTER_ID'];
			$this->ScenarioId = $myRow['SCENARIO_ID'];
			$this->CharacterOrderNo = $myRow['CHARACTER_ORDER_NO'];
			$this->CharacterName = $myRow['CHARACTER_NAME'];
			$this->CharacterChara = $myRow['CHARACTER_CHARA'];
		}//end while
    }//end function

// -------------------------------------------------------------
//    DB更新　INSERT
// -------------------------------------------------------------
	function clsSwCharacterDbInsert($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valCharacterId = $this->CharacterId;
		$valScenarioId = $this->ScenarioId;
		$valCharacterOrderNo = $this->CharacterOrderNo;
		$valCharacterName = $this->CharacterName;
		$valCharacterChara = $this->CharacterChara;
		//INSERT SQL
		$strSQL = <<<END_OF_SQL

		INSERT INTO SW_CHARACTER(
			  SCENARIO_ID
			, CHARACTER_ORDER_NO
			, CHARACTER_NAME
			, CHARACTER_CHARA
		) values (
			  :ScenarioId
			, :CharacterOrderNo
			, :CharacterName
			, :CharacterChara
		);
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータ設定
		$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
		$stmt->bindParam(':CharacterOrderNo', $valCharacterOrderNo, PDO::PARAM_INT);
		$stmt->bindParam(':CharacterName', $valCharacterName, PDO::PARAM_STR);
		$stmt->bindParam(':CharacterChara', $valCharacterChara, PDO::PARAM_STR);
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
	function clsSwCharacterDbUpdate($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valCharacterId = $this->CharacterId;
		$valScenarioId = $this->ScenarioId;
		$valCharacterOrderNo = $this->CharacterOrderNo;
		$valCharacterName = $this->CharacterName;
		$valCharacterChara = $this->CharacterChara;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_CHARACTER
				WHERE CHARACTER_ID = :CharacterId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':CharacterId', $valCharacterId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwCharacter ->> NOT ENTRY!");
		}else{
			//UPDATE SQL
			$strSQL = <<<END_OF_SQL

			UPDATE SW_CHARACTER SET 
				  SCENARIO_ID = :ScenarioId
				, CHARACTER_ORDER_NO = :CharacterOrderNo
				, CHARACTER_NAME = :CharacterName
				, CHARACTER_CHARA = :CharacterChara
				WHERE CHARACTER_ID = :CharacterId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータ設定
			$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
			$stmt->bindParam(':CharacterOrderNo', $valCharacterOrderNo, PDO::PARAM_INT);
			$stmt->bindParam(':CharacterName', $valCharacterName, PDO::PARAM_STR);
			$stmt->bindParam(':CharacterChara', $valCharacterChara, PDO::PARAM_STR);
			//パラメータ設定
			$stmt->bindParam(':CharacterId', $valCharacterId, PDO::PARAM_INT);
			//EXECUTE
			$stmt->execute();
		}//end if
	}//end function

// -------------------------------------------------------------
//    DB更新　DELETE
// -------------------------------------------------------------
	function clsSwCharacterDbDelete($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valCharacterId = $this->CharacterId;
		$valScenarioId = $this->ScenarioId;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_CHARACTER
				WHERE CHARACTER_ID = :CharacterId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':CharacterId', $valCharacterId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwCharacter ->> NOT ENTRY!");
		}else{
			//DELETE SQL
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_CHARACTER
				WHERE CHARACTER_ID = :CharacterId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':CharacterId', $valCharacterId, PDO::PARAM_INT);
			$stmt->execute();
		}//end if
		// 結果セットを開放
		$stmt->closeCursor();   //PHP8: $myResult は未定義(mysqli 時代の残骸)で Fatal になる
	}//end function

// -------------------------------------------------------------
//    登場人物の並び順を整理する
// -------------------------------------------------------------
	function fncAdjustCharacterOrderNo($mySqlConnObj,$valScenarioId){
		//並び順初期化
		$CharaOrderNo = 0;
		//更新オブジェクトを準備する
		$strUpdSQL = <<<END_OF_SQL
			
			UPDATE SW_CHARACTER SET
				CHARACTER_ORDER_NO = :CharaOrderNo
				WHERE CHARACTER_ID = :CharacterId;
END_OF_SQL;
		$upd_stmt = $mySqlConnObj->prepare($strUpdSQL);
		//パラメータ設定
		$upd_stmt->bindParam(':CharaOrderNo', $CharaOrderNo, PDO::PARAM_INT);
		$upd_stmt->bindParam(':CharacterId', $CharacterId, PDO::PARAM_INT);

		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_CHARACTER
				WHERE SCENARIO_ID = :ScenarioId
				ORDER BY CHARACTER_ORDER_NO;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
		$stmt->execute();
		//更新する
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$CharaOrderNo = $CharaOrderNo + 100;
			$CharacterId = $myRow['CHARACTER_ID'];
			$CharacterOrderNo = $myRow['CHARACTER_ORDER_NO'];
			
			if( $CharacterOrderNo != $CharaOrderNo){
				//EXECUTE
				$upd_stmt->execute();
			}
		}//end while
	}
// -------------------------------------------------------------
//    シナリオのキャラクタを連想配列にする
// -------------------------------------------------------------
	function fncGetScenarioCharacter($mySqlConnObj,$valScenarioId){
		//配列初期化
		$retArray = array();
		//スタイルを取得
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_CHARACTER
				WHERE SCENARIO_ID = :ScenarioId
				ORDER BY CHARACTER_ID;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
		$stmt->execute();
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$CharacterId = $myRow['CHARACTER_ID'];
			$CharacterName = $myRow['CHARACTER_NAME'];
			
			$retArray[$CharacterId] = $CharacterName;
		}
		return	$retArray;
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