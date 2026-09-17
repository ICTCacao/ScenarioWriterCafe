<?php
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//     USER_INFO ﾃﾞｰﾀ管理ｸﾗｽ
//     clsSwUser
// -----------------------------------------------------------
class clsSwUser{
	var $UserId;                          //ユーザーID
	var $UserMailad;                      //メールアドレス
	var $UserPasswd;                      //パスワード
	var $UserName;                        //ユーザー名
	var $UserMaxScenario;                 //作成可能シナリオ数
// ｺﾝｽﾄﾗｸﾀ
    function clsfncSwUser(){
    }
// ﾌﾟﾛﾊﾟﾃｨ
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserId
//    ユーザーID を返す
// --------------------------------------
	function clsSwUserGetUserId(){
		return $this->UserId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserId
//    ユーザーID を設定する
// --------------------------------------
	function clsSwUserSetUserId($valUserId){
		$this->UserId = $valUserId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserMailad
//    メールアドレス を返す
// --------------------------------------
	function clsSwUserGetUserMailad(){
		return $this->UserMailad;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserMailad
//    メールアドレス を設定する
// --------------------------------------
	function clsSwUserSetUserMailad($valUserMailad){
		$this->UserMailad = $valUserMailad;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserPasswd
//    パスワード を返す
// --------------------------------------
	function clsSwUserGetUserPasswd(){
		return $this->UserPasswd;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserPasswd
//    パスワード を設定する
// --------------------------------------
	function clsSwUserSetUserPasswd($valUserPasswd){
		$this->UserPasswd = $valUserPasswd;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserName
//    ユーザー名 を返す
// --------------------------------------
	function clsSwUserGetUserName(){
		return $this->UserName;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserName
//    ユーザー名 を設定する
// --------------------------------------
	function clsSwUserSetUserName($valUserName){
		$this->UserName = $valUserName;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserMaxScenario
//    作成可能シナリオ数 を返す
// --------------------------------------
	function clsSwUserGetUserMaxScenario(){
		return $this->UserMaxScenario;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserMaxScenario
//    作成可能シナリオ数 を設定する
// --------------------------------------
	function clsSwUserSetUserMaxScenario($valUserMaxScenario){
		if ($valUserMaxScenario == '' ){
			$valUserMaxScenario = '9999';
		}
		$this->UserMaxScenario = $valUserMaxScenario;
	}
// -------------------------------------------------------------
//    ｸﾗｽ初期化
// -------------------------------------------------------------
	function clsSwUserInit($mySqlConnObj,$valUserId){
		//ﾌﾟﾛﾊﾟﾃｨの初期化
		$this->UserId = '';                          //ユーザーID
		$this->UserMailad = '';                      //メールアドレス
		$this->UserPasswd = '';                      //パスワード
		$this->UserName = '';                        //ユーザー名
		$this->UserMaxScenario = '9999';             //作成可能シナリオ数
		//DB から ﾃﾞｰﾀを取得しﾌﾟﾛﾊﾟﾃｨにｾｯﾄする
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER
				WHERE USER_ID = :UserId;
END_OF_SQL;

		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
		$stmt->execute();
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$this->UserId = $myRow['USER_ID'];
			$this->UserMailad = $myRow['USER_MAILAD'];
			$this->UserPasswd = $myRow['USER_PASSWD'];
			$this->UserName = $myRow['USER_NAME'];
			$this->UserMaxScenario = $myRow['USER_MAX_SCENARIO'];
		}//end while

	}//end function

// -------------------------------------------------------------
//    メールアドレス登録チェック
// -------------------------------------------------------------
	function clsSwUserCheckMailAd($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valUserId = $this->UserId;
		$valUserMailad = $this->UserMailad;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER
				WHERE USER_MAILAD = :UserMailad;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':UserMailad', $valUserMailad, PDO::PARAM_STR);
		$stmt->execute();
        //件数取得
        $myRowCnt = $stmt->rowCount();
        if($myRowCnt == 0 ){
        	//登録されていない
            return '';
        }else{
	        while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
	        	//USER_IDを返す
	            return $myRow['USER_ID'];
	        }//end while
		}
	}

// -------------------------------------------------------------
//    DB更新　INSERT
// -------------------------------------------------------------
	function clsSwUserDbInsert($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valUserId = $this->UserId;
		$valUserMailad = $this->UserMailad;
		$valUserPasswd = $this->UserPasswd;
		$valUserName = $this->UserName;
		$valUserMaxScenario = $this->UserMaxScenario;
		//INSERT SQL
		$strSQL = <<<END_OF_SQL

			INSERT INTO SW_USER(
				  USER_MAILAD
				, USER_PASSWD
				, USER_NAME
				, USER_MAX_SCENARIO
			) values (
				  :UserMailad
				, :UserPasswd
				, :UserName
				, :UserMaxScenario
			);
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータ設定
		$stmt->bindParam(':UserMailad', $valUserMailad, PDO::PARAM_STR);
		$stmt->bindParam(':UserPasswd', $valUserPasswd, PDO::PARAM_STR);
		$stmt->bindParam(':UserName', $valUserName, PDO::PARAM_STR);
		$stmt->bindParam(':UserMaxScenario', $valUserMaxScenario, PDO::PARAM_INT);
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
	function clsSwUserDbUpdate($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valUserId = $this->UserId;
		$valUserMailad = $this->UserMailad;
		$valUserPasswd = $this->UserPasswd;
		$valUserName = $this->UserName;
		$valUserMaxScenario = $this->UserMaxScenario;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER
				WHERE USER_ID = :UserId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_STR);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwUser ->> NOT ENTRY!");
		}else{
			//UPDATE SQL
			$strSQL = <<<END_OF_SQL

			UPDATE SW_USER SET 
				  USER_MAILAD = :UserMailad
				, USER_PASSWD = :UserPasswd
				, USER_NAME = :UserName
				, USER_MAX_SCENARIO = :UserMaxScenario
				WHERE USER_ID = :UserId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータ設定
			$stmt->bindParam(':UserMailad', $valUserMailad, PDO::PARAM_STR);
			$stmt->bindParam(':UserPasswd', $valUserPasswd, PDO::PARAM_STR);
			$stmt->bindParam(':UserName', $valUserName, PDO::PARAM_STR);
			$stmt->bindParam(':UserMaxScenario', $valUserMaxScenario, PDO::PARAM_INT);
			//パラメータ設定
			$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
			//EXECUTE
			$stmt->execute();
		}//end if
	}//end function

// -------------------------------------------------------------
//    DB更新　DELETE
// -------------------------------------------------------------
	function clsSwUserDbDelete($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valUserId = $this->UserId;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_USER
				WHERE USER_ID = :UserId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_STR);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwUser ->> NOT ENTRY!");
		}else{
			//DELETE SQL
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_USER
				WHERE USER_ID = :UserId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_STR);
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