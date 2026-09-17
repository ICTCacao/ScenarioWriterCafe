<?php
	if (!function_exists('swDb_Now')) { include_once(__DIR__ . '/../include/swDb.php'); }
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//      ﾃﾞｰﾀ管理ｸﾗｽ
//     clsSwContact
// -----------------------------------------------------------
class clsSwContact{
	var $ContactId;                       //ID
	var $ContactMailad;                   //MAILAD
	var $ContactName;                     //NAME
	var $ContactSubject;                  //SUBJECT
	var $ContactBody;                     //BODY
	var $ContactReply;                    //REPLY
	var $ContactDate;                     //DATE
// ｺﾝｽﾄﾗｸﾀ
    function clsfncSwContact(){
    }
// ﾌﾟﾛﾊﾟﾃｨ
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ContactId
//    ID を返す
// --------------------------------------
	function clsSwContactGetContactId(){
		return $this->ContactId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ContactId
//    ID を設定する
// --------------------------------------
	function clsSwContactSetContactId($valContactId){
		$this->ContactId = $valContactId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ContactMailad
//    MAILAD を返す
// --------------------------------------
	function clsSwContactGetContactMailad(){
		return $this->ContactMailad;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ContactMailad
//    MAILAD を設定する
// --------------------------------------
	function clsSwContactSetContactMailad($valContactMailad){
		$this->ContactMailad = $valContactMailad;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ContactName
//    NAME を返す
// --------------------------------------
	function clsSwContactGetContactName(){
		return $this->ContactName;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ContactName
//    NAME を設定する
// --------------------------------------
	function clsSwContactSetContactName($valContactName){
		$this->ContactName = $valContactName;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ContactSubject
//    SUBJECT を返す
// --------------------------------------
	function clsSwContactGetContactSubject(){
		return $this->ContactSubject;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ContactSubject
//    SUBJECT を設定する
// --------------------------------------
	function clsSwContactSetContactSubject($valContactSubject){
		$this->ContactSubject = $valContactSubject;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ContactBody
//    BODY を返す
// --------------------------------------
	function clsSwContactGetContactBody(){
		return $this->ContactBody;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ContactBody
//    BODY を設定する
// --------------------------------------
	function clsSwContactSetContactBody($valContactBody){
		$this->ContactBody = $valContactBody;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ContactReply
//    REPLY を返す
// --------------------------------------
	function clsSwContactGetContactReply(){
		return $this->ContactReply;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ContactReply
//    REPLY を設定する
// --------------------------------------
	function clsSwContactSetContactReply($valContactReply){
		$this->ContactReply = $valContactReply;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ContactDate
//    DATE を返す
// --------------------------------------
	function clsSwContactGetContactDate(){
		return $this->ContactDate;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ContactDate
//    DATE を設定する
// --------------------------------------
	function clsSwContactSetContactDate($valContactDate){
		$this->ContactDate = $valContactDate;
	}
// -------------------------------------------------------------
//    ｸﾗｽ初期化
// -------------------------------------------------------------
	function clsSwContactInit($mySqlConnObj,$valContactId){
		//ﾌﾟﾛﾊﾟﾃｨの初期化
		$this->ContactId = '';                       //ID
		$this->ContactMailad = '';                   //MAILAD
		$this->ContactName = '';                     //NAME
		$this->ContactSubject = '';                  //SUBJECT
		$this->ContactBody = '';                     //BODY
		$this->ContactReply = '';                    //REPLY
		$this->ContactDate = '';                     //DATE
		//DB から ﾃﾞｰﾀを取得しﾌﾟﾛﾊﾟﾃｨにｾｯﾄする
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_CONTACT
				WHERE CONTACT_ID = :ContactId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':ContactId', $valContactId, PDO::PARAM_INT);
		$stmt->execute();
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$this->ContactId = $myRow['CONTACT_ID'];
			$this->ContactMailad = $myRow['CONTACT_MAILAD'];
			$this->ContactName = $myRow['CONTACT_NAME'];
			$this->ContactSubject = $myRow['CONTACT_SUBJECT'];
			$this->ContactBody = $myRow['CONTACT_BODY'];
			$this->ContactReply = $myRow['CONTACT_REPLY'];
			$this->ContactDate = $myRow['CONTACT_DATE'];
		}//end while
    }//end function

// -------------------------------------------------------------
//    DB更新　INSERT
// -------------------------------------------------------------
	function clsSwContactDbInsert($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valContactId = $this->ContactId;
		$valContactMailad = $this->ContactMailad;
		$valContactName = $this->ContactName;
		$valContactSubject = $this->ContactSubject;
		$valContactBody = $this->ContactBody;
		$valContactReply = $this->ContactReply;
		$valContactDate = $this->ContactDate;
		//INSERT SQL
		$strSQL = <<<END_OF_SQL

			INSERT INTO SW_CONTACT(
				  CONTACT_MAILAD
				, CONTACT_NAME
				, CONTACT_SUBJECT
				, CONTACT_BODY
				, CONTACT_REPLY
				, CONTACT_DATE
			) values (
				  :ContactMailad
				, :ContactName
				, :ContactSubject
				, :ContactBody
				, :ContactReply
				, :SwNow
			);
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//日時は PHP 側の時刻を bind（SQLite の current_timestamp は UTC のため。MySQL でも同じ書式）
		$swNow = swDb_Now();
		$stmt->bindValue(':SwNow', $swNow, PDO::PARAM_STR);
		//パラメータ設定
		$stmt->bindParam(':ContactMailad', $valContactMailad, PDO::PARAM_STR);
		$stmt->bindParam(':ContactName', $valContactName, PDO::PARAM_STR);
		$stmt->bindParam(':ContactSubject', $valContactSubject, PDO::PARAM_STR);
		$stmt->bindParam(':ContactBody', $valContactBody, PDO::PARAM_STR);
		$stmt->bindParam(':ContactReply', $valContactReply, PDO::PARAM_STR);
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
	function clsSwContactDbUpdate($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valContactId = $this->ContactId;
		$valContactMailad = $this->ContactMailad;
		$valContactName = $this->ContactName;
		$valContactSubject = $this->ContactSubject;
		$valContactBody = $this->ContactBody;
		$valContactReply = $this->ContactReply;
		$valContactDate = $this->ContactDate;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_CONTACT
				WHERE CONTACT_ID = :ContactId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':ContactId', $valContactId, PDO::PARAM_STR);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwContact ->> NOT ENTRY!");
		}else{
			//UPDATE SQL
			$strSQL = <<<END_OF_SQL

			UPDATE SW_CONTACT SET 
				  CONTACT_MAILAD = :ContactMailad
				, CONTACT_NAME = :ContactName
				, CONTACT_SUBJECT = :ContactSubject
				, CONTACT_BODY = :ContactBody
				, CONTACT_REPLY = :ContactReply
				, CONTACT_DATE = :SwNow
				WHERE CONTACT_ID = :ContactId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//日時は PHP 側の時刻を bind（SQLite の current_timestamp は UTC のため。MySQL でも同じ書式）
			$swNow = swDb_Now();
			$stmt->bindValue(':SwNow', $swNow, PDO::PARAM_STR);
			//パラメータ設定
			$stmt->bindParam(':ContactMailad', $valContactMailad, PDO::PARAM_STR);
			$stmt->bindParam(':ContactName', $valContactName, PDO::PARAM_STR);
			$stmt->bindParam(':ContactSubject', $valContactSubject, PDO::PARAM_STR);
			$stmt->bindParam(':ContactBody', $valContactBody, PDO::PARAM_STR);
			$stmt->bindParam(':ContactReply', $valContactReply, PDO::PARAM_STR);
			//パラメータのセット
			$stmt->bindParam(':ContactId', $valContactId, PDO::PARAM_STR);
			//EXECUTE
			$stmt->execute();
		}//end if
	}//end function

// -------------------------------------------------------------
//    DB更新　DELETE
// -------------------------------------------------------------
	function clsSwContactDbDelete($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valContactId = $this->ContactId;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_CONTACT
				WHERE CONTACT_ID = :ContactId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':ContactId', $valContactId, PDO::PARAM_STR);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwContact ->> NOT ENTRY!");
		}else{
			//DELETE SQL
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_CONTACT
				WHERE CONTACT_ID = :ContactId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':ContactId', $valContactId, PDO::PARAM_STR);
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