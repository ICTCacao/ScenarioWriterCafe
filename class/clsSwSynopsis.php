<?php
	if (!function_exists('swDb_Now')) { include_once(__DIR__ . '/../include/swDb.php'); }
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//     シノプシス ﾃﾞｰﾀ管理ｸﾗｽ
//     clsSwSynopsis
// -----------------------------------------------------------
class clsSwSynopsis{
	var $SynopsisId;                      //SYNOPSIS_ID
	var $ScenarioId;                      //SCENARIO_ID
	var $Synopsis;                        //SYNOPSIS
	var $UpdateDate;                      //更新日時
// ｺﾝｽﾄﾗｸﾀ
    function clsfncSwSynopsis(){
    }
// ﾌﾟﾛﾊﾟﾃｨ
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get SynopsisId
//    SYNOPSIS_ID を返す
// --------------------------------------
	function clsSwSynopsisGetSynopsisId(){
		return $this->SynopsisId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set SynopsisId
//    SYNOPSIS_ID を設定する
// --------------------------------------
	function clsSwSynopsisSetSynopsisId($valSynopsisId){
		$this->SynopsisId = $valSynopsisId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ScenarioId
//    SCENARIO_ID を返す
// --------------------------------------
	function clsSwSynopsisGetScenarioId(){
		return $this->ScenarioId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ScenarioId
//    SCENARIO_ID を設定する
// --------------------------------------
	function clsSwSynopsisSetScenarioId($valScenarioId){
		$this->ScenarioId = $valScenarioId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get Synopsis
//    SYNOPSIS を返す
// --------------------------------------
	function clsSwSynopsisGetSynopsis(){
		return $this->Synopsis;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set Synopsis
//    SYNOPSIS を設定する
// --------------------------------------
	function clsSwSynopsisSetSynopsis($valSynopsis){
		$this->Synopsis = $valSynopsis;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UpdateDate
//    更新日時 を返す
// --------------------------------------
	function clsSwSynopsisGetUpdateDate(){
		return $this->UpdateDate;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UpdateDate
//    更新日時 を設定する
// --------------------------------------
	function clsSwSynopsisSetUpdateDate($valUpdateDate){
		$this->UpdateDate = $valUpdateDate;
	}
// -------------------------------------------------------------
//    ｸﾗｽ初期化
// -------------------------------------------------------------
	function clsSwSynopsisInit($mySqlConnObj,$valSynopsisId){
		//ﾌﾟﾛﾊﾟﾃｨの初期化
		$this->SynopsisId = '';                      //SYNOPSIS_ID
		$this->ScenarioId = '';                      //SCENARIO_ID
		$this->Synopsis = '';                        //SYNOPSIS
		$this->UpdateDate = '';                      //更新日時
		//DB から ﾃﾞｰﾀを取得しﾌﾟﾛﾊﾟﾃｨにｾｯﾄする
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SYNOPSIS
				WHERE SYNOPSIS_ID = :SynopsisId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':SynopsisId', $valSynopsisId, PDO::PARAM_INT);
		$stmt->execute();
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$this->SynopsisId = $myRow['SYNOPSIS_ID'];
			$this->ScenarioId = $myRow['SCENARIO_ID'];
			$this->Synopsis = $myRow['SYNOPSIS'];
			$this->UpdateDate = $myRow['UPDATE_DATE'];
		}//end while
    }//end function

// -------------------------------------------------------------
//    登録確認
// -------------------------------------------------------------
	function clsSwSynopsisInitScenarioId($mySqlConnObj,$valScenarioId){
		//ﾌﾟﾛﾊﾟﾃｨの初期化
		$this->SynopsisId = '';                      //SYNOPSIS_ID
		$this->ScenarioId = '';                      //SCENARIO_ID
		$this->Synopsis = '';                        //SYNOPSIS
		$this->UpdateDate = '';                      //更新日時
		//DB からScenarioIdで検索する
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SYNOPSIS
				WHERE SCENARIO_ID = :SynopsisId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':SynopsisId', $valScenarioId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			return	false;
		}else{
			while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
				$this->SynopsisId = $myRow['SYNOPSIS_ID'];
				$this->ScenarioId = $myRow['SCENARIO_ID'];
				$this->Synopsis = $myRow['SYNOPSIS'];
				$this->UpdateDate = $myRow['UPDATE_DATE'];
			}//end while
			return	true;
		}
    }//end function

// -------------------------------------------------------------
//    DB更新　INSERT
// -------------------------------------------------------------
	function clsSwSynopsisDbInsert($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valSynopsisId = $this->SynopsisId;
		$valScenarioId = $this->ScenarioId;
		$valSynopsis = $this->Synopsis;
		$valUpdateDate = $this->UpdateDate;
		//INSERT SQL
		$strSQL = <<<END_OF_SQL

			INSERT INTO SW_SYNOPSIS(
				  SCENARIO_ID
				, SYNOPSIS
				, UPDATE_DATE
			) values (
				  :ScenarioId
				, :Synopsis
				, :SwNow
			);
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//日時は PHP 側の時刻を bind（SQLite の current_timestamp は UTC のため。MySQL でも同じ書式）
		$swNow = swDb_Now();
		$stmt->bindValue(':SwNow', $swNow, PDO::PARAM_STR);
		//パラメータ設定
		$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
		$stmt->bindParam(':Synopsis', $valSynopsis, PDO::PARAM_STR);
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
	function clsSwSynopsisDbUpdate($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valSynopsisId = $this->SynopsisId;
		$valScenarioId = $this->ScenarioId;
		$valSynopsis = $this->Synopsis;
		$valUpdateDate = $this->UpdateDate;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SYNOPSIS
				WHERE SYNOPSIS_ID = :SynopsisId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':SynopsisId', $valSynopsisId, PDO::PARAM_STR);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwSynopsis ->> NOT ENTRY!");
		}else{
			//UPDATE SQL
			$strSQL = <<<END_OF_SQL

			UPDATE SW_SYNOPSIS SET 
				  SCENARIO_ID = :ScenarioId
				, SYNOPSIS = :Synopsis
				, UPDATE_DATE = :SwNow
				WHERE SYNOPSIS_ID = :SynopsisId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//日時は PHP 側の時刻を bind（SQLite の current_timestamp は UTC のため。MySQL でも同じ書式）
			$swNow = swDb_Now();
			$stmt->bindValue(':SwNow', $swNow, PDO::PARAM_STR);
			//パラメータ設定
			$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
			$stmt->bindParam(':Synopsis', $valSynopsis, PDO::PARAM_STR);
			//パラメータのセット
			$stmt->bindParam(':SynopsisId', $valSynopsisId, PDO::PARAM_STR);
			//EXECUTE
			$stmt->execute();
		}//end if
	}//end function

// -------------------------------------------------------------
//    DB更新　DELETE
// -------------------------------------------------------------
	function clsSwSynopsisDbDelete($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valSynopsisId = $this->SynopsisId;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SYNOPSIS
				WHERE SYNOPSIS_ID = :SynopsisId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':SynopsisId', $valSynopsisId, PDO::PARAM_STR);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwSynopsis ->> NOT ENTRY!");
		}else{
			//DELETE SQL
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_SYNOPSIS
				WHERE SYNOPSIS_ID = ?;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(1, $valSynopsisId, PDO::PARAM_STR);
			//EXECUTE
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