<?php
	if (!function_exists('swDb_Now')) { include_once(__DIR__ . '/../include/swDb.php'); }
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//     USERログイン情報 ﾃﾞｰﾀ管理ｸﾗｽ
//     clsSwUserLoginInfo
// -----------------------------------------------------------
class clsSwUserLoginInfo{
	var $UserLoginId;                     //USERログインID
	var $UserId;                          //USER_ID
	var $UserLoginDate;                   //USERログイン日時
// ｺﾝｽﾄﾗｸﾀ
    function clsfncSwUserLoginInfo(){
    }
// ﾌﾟﾛﾊﾟﾃｨ
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserLoginId
//    USERログインID を返す
// --------------------------------------
	function clsSwUserLoginInfoGetUserLoginId(){
		return $this->UserLoginId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserLoginId
//    USERログインID を設定する
// --------------------------------------
	function clsSwUserLoginInfoSetUserLoginId($valUserLoginId){
		$this->UserLoginId = $valUserLoginId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserId
//    USER_ID を返す
// --------------------------------------
	function clsSwUserLoginInfoGetUserId(){
		return $this->UserId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserId
//    USER_ID を設定する
// --------------------------------------
	function clsSwUserLoginInfoSetUserId($valUserId){
		$this->UserId = $valUserId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserLoginDate
//    USERログイン日時 を返す
// --------------------------------------
	function clsSwUserLoginInfoGetUserLoginDate(){
		return $this->UserLoginDate;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserLoginDate
//    USERログイン日時 を設定する
// --------------------------------------
	function clsSwUserLoginInfoSetUserLoginDate($valUserLoginDate){
		$this->UserLoginDate = $valUserLoginDate;
	}
// -------------------------------------------------------------
//    ｸﾗｽ初期化
// -------------------------------------------------------------
	function clsSwUserLoginInfoInit($mySqlConnObj,$valUserLoginId){
		//ﾌﾟﾛﾊﾟﾃｨの初期化
		$this->UserLoginId = '';                     //USERログインID
		$this->UserId = '';                          //USER_ID
		$this->UserLoginDate = '';                   //USERログイン日時
		//DB から ﾃﾞｰﾀを取得しﾌﾟﾛﾊﾟﾃｨにｾｯﾄする
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER_LOGIN_INFO
				WHERE USER_LOGIN_ID = :UserLoginId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':UserLoginId', $valUserLoginId, PDO::PARAM_INT);
		$stmt->execute();
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$this->UserLoginId = $myRow['USER_LOGIN_ID'];
			$this->UserId = $myRow['USER_ID'];
			$this->UserLoginDate = $myRow['USER_LOGIN_DATE'];
		}//end while
    }//end function

// -------------------------------------------------------------
//    DB更新　INSERT
// -------------------------------------------------------------
	function clsSwUserLoginInfoDbInsert($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valUserLoginId = $this->UserLoginId;
		$valUserId = $this->UserId;
		$valUserLoginDate = $this->UserLoginDate;
			//INSERT SQL
			$strSQL = <<<END_OF_SQL

			INSERT INTO SW_USER_LOGIN_INFO(
				  USER_LOGIN_ID
				, USER_ID
				, USER_LOGIN_DATE
			) values (
				  :UserLoginId
				, :UserId
				, :UserLoginDate
			);
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータ設定
		$stmt->bindParam(':UserLoginId', $valUserLoginId, PDO::PARAM_STR);
		$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
		//ログイン日時は PHP 側の時刻（SQLite の current_timestamp は UTC になるため DB 側に任せない）
		$valUserLoginDate = swDb_Now();
		$stmt->bindParam(':UserLoginDate', $valUserLoginDate, PDO::PARAM_STR);
		//EXECUTE
		$stmt->execute();
	}//end function

// -------------------------------------------------------------
//    DB更新　UPDATE
// -------------------------------------------------------------
	function clsSwUserLoginInfoDbUpdate($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valUserLoginId = $this->UserLoginId;
		$valUserId = $this->UserId;
		$valUserLoginDate = $this->UserLoginDate;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER_LOGIN_INFO
				WHERE USER_LOGIN_ID = :UserLoginId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':UserLoginId', $valUserLoginId, PDO::PARAM_STR);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwUserLoginInfo ->> NOT ENTRY!");
		}else{
			//UPDATE SQL
			$strSQL = <<<END_OF_SQL

			UPDATE SW_USER_LOGIN_INFO SET 
				  USER_ID = :UserId
				, USER_LOGIN_DATE = :UserLoginDate
				WHERE USER_LOGIN_ID = :UserLoginId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータ設定
			$valUserLoginDate = swDb_Now();
			$stmt->bindParam(':UserLoginDate', $valUserLoginDate, PDO::PARAM_STR);
			$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
			$stmt->bindParam(':UserLoginId', $valUserLoginId, PDO::PARAM_STR);
			//EXECUTE
			$stmt->execute();
		}//end if
	}//end function

// -------------------------------------------------------------
//    DB更新　DELETE
// -------------------------------------------------------------
	function clsSwUserLoginInfoDbDelete($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valUserLoginId = $this->UserLoginId;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER_LOGIN_INFO
				WHERE USER_LOGIN_ID = :UserLoginId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':UserLoginId', $valUserLoginId, PDO::PARAM_STR);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwUserLoginInfo ->> NOT ENTRY!");
		}else{
			//DELETE SQL
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_USER_LOGIN_INFO
				WHERE USER_LOGIN_ID = :UserLoginId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':UserLoginId', $valUserLoginId, PDO::PARAM_STR);
			$stmt->execute();
		}//end if
	}//end function

// -------------------------------------------------------------
//    DB更新　USER_ID で　DELETE 
// -------------------------------------------------------------
	function clsSwUserLoginInfoDbDeleteFromUserId($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valUserId = $this->UserId;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER_LOGIN_INFO
				WHERE USER_ID = :UserId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_STR);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			return;
		}else{
			//DELETE SQL
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_USER_LOGIN_INFO
				WHERE USER_ID = :UserId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_STR);
			$stmt->execute();
		}//end if
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