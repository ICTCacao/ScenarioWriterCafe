<?php
	if (!function_exists('swDb_Now')) { include_once(__DIR__ . '/../include/swDb.php'); }
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//      ﾃﾞｰﾀ管理ｸﾗｽ
//     clsSwScenario
// -----------------------------------------------------------
class clsSwScenario{
	var $ScenarioId;                    //シナリオID
	var $UserId;                        //USER_ID
	var $ScenarioTitle;                 //タイトル
	var $ScenarioSubtitle;              //サブタイトル
	var $ScenarioWriterName;			//作者名
	var $ScenarioMemo;					//メモ
	var $ScenarioDate;					//執筆日
	var $ScenarioCategory;				//分類
// ｺﾝｽﾄﾗｸﾀ
    function clsfncSwScenario(){
    }
// ﾌﾟﾛﾊﾟﾃｨ
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ScenarioId
//    シナリオID を返す
// --------------------------------------
	function clsSwScenarioGetScenarioId(){
		return $this->ScenarioId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ScenarioId
//    シナリオID を設定する
// --------------------------------------
	function clsSwScenarioSetScenarioId($valScenarioId){
		$this->ScenarioId = $valScenarioId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get UserId
//    USER_ID を返す
// --------------------------------------
	function clsSwScenarioGetUserId(){
		return $this->UserId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set UserId
//    USER_ID を設定する
// --------------------------------------
	function clsSwScenarioSetUserId($valUserId){
		$this->UserId = $valUserId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ScenarioTitle
//    タイトル を返す
// --------------------------------------
	function clsSwScenarioGetScenarioTitle(){
		return $this->ScenarioTitle;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ScenarioTitle
//    タイトル を設定する
// --------------------------------------
	function clsSwScenarioSetScenarioTitle($valScenarioTitle){
		$this->ScenarioTitle = $valScenarioTitle;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ScenarioSubtitle
//    サブタイトル を返す
// --------------------------------------
	function clsSwScenarioGetScenarioSubtitle(){
		return $this->ScenarioSubtitle;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ScenarioSubtitle
//    サブタイトル を設定する
// --------------------------------------
	function clsSwScenarioSetScenarioSubtitle($valScenarioSubtitle){
		$this->ScenarioSubtitle = $valScenarioSubtitle;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ScenarioWriterName
//    作者名 を返す
// --------------------------------------
	function clsSwScenarioGetScenarioWriterName(){
		return $this->ScenarioWriterName;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ScenarioWriterName
//    作者名 を設定する
// --------------------------------------
	function clsSwScenarioSetScenarioWriterName($valScenarioWriterName){
		$this->ScenarioWriterName = $valScenarioWriterName;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ScenarioMemo
//    メモ を返す
// --------------------------------------
	function clsSwScenarioGetScenarioMemo(){
		return $this->ScenarioMemo;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ScenarioMemo
//    メモ を設定する
// --------------------------------------
	function clsSwScenarioSetScenarioMemo($valScenarioMemo){
		$this->ScenarioMemo = $valScenarioMemo;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ScenarioDate
//    執筆日 を返す
// --------------------------------------
	function clsSwScenarioGetScenarioDate(){
		return $this->ScenarioDate;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ScenarioDate
//    執筆日 を設定する
// --------------------------------------
	function clsSwScenarioSetScenarioDate($valScenarioDate){
		$this->ScenarioDate = $valScenarioDate;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ScenarioCategory
//    分類 を返す
// --------------------------------------
	function clsSwScenarioGetScenarioCategory(){
		return $this->ScenarioCategory;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ScenarioCategory
//    分類 を設定する
// --------------------------------------
	function clsSwScenarioSetScenarioCategory($valScenarioCategory){
		$this->ScenarioCategory = $valScenarioCategory;
	}
// -------------------------------------------------------------
//    ｸﾗｽ初期化
// -------------------------------------------------------------
	function clsSwScenarioInit($mySqlConnObj,$valScenarioId){
		//ﾌﾟﾛﾊﾟﾃｨの初期化
		$this->ScenarioId = '';                      //シナリオID
		$this->UserId = '';                          //USER_ID
		$this->ScenarioTitle = '';                   //タイトル
		$this->ScenarioSubtitle = '';                //サブタイトル
		$this->ScenarioWriterName = '';              //作者名
		$this->ScenarioMemo = '';                    //メモ
		$this->ScenarioDate = '';                    //執筆日
		$this->ScenarioCategory = '';                //分類
		//DB から ﾃﾞｰﾀを取得しﾌﾟﾛﾊﾟﾃｨにｾｯﾄする
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SCENARIO
				WHERE SCENARIO_ID = :ScenarioId;
END_OF_SQL;

		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
		$stmt->execute();
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$this->ScenarioId = $myRow['SCENARIO_ID'];
			$this->UserId = $myRow['USER_ID'];
			$this->ScenarioTitle = $myRow['SCENARIO_TITLE'];
			$this->ScenarioSubtitle = $myRow['SCENARIO_SUBTITLE'];
			$this->ScenarioWriterName = $myRow['SCENARIO_WRITER_NAME'];
			$this->ScenarioMemo = $myRow['SCENARIO_MEMO'];
			$this->ScenarioDate = $myRow['SCENARIO_DATE'];
			$this->ScenarioCategory = $myRow['SCENARIO_CATEGORY'];
		}//end while
	}//end function

// -------------------------------------------------------------
//    登録されているシナリオ数を取得する
// -------------------------------------------------------------
function clsSwScenarioCount($mySqlConnObj,$valUserId){
		//DB から ﾃﾞｰﾀを取得しﾌﾟﾛﾊﾟﾃｨにｾｯﾄする
		$strSQL = <<<END_OF_SQL
		
			SELECT * FROM SW_SCENARIO
				WHERE USER_ID = :UserId;
END_OF_SQL;
	$stmt = $mySqlConnObj->prepare($strSQL);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	//パラメータのセット
	$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_STR);
	$stmt->execute();
	//件数取得
	$myRowCnt = $stmt->rowCount();

	return	$myRowCnt;
}

// -------------------------------------------------------------
//    DB更新　INSERT
// -------------------------------------------------------------
	function clsSwScenarioDbInsert($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valScenarioId = $this->ScenarioId;
		$valUserId = $this->UserId;
		$valScenarioTitle = $this->ScenarioTitle;
		$valScenarioSubtitle = $this->ScenarioSubtitle;
		$valScenarioWriterName = $this->ScenarioWriterName;
		$valScenarioMemo = $this->ScenarioMemo;
		$valScenarioDate = $this->ScenarioDate;
		$valScenarioCategory = $this->ScenarioCategory;
		//INSERT SQL
		$strSQL = <<<END_OF_SQL

			INSERT INTO SW_SCENARIO(
				  USER_ID
				, SCENARIO_TITLE
				, SCENARIO_SUBTITLE
				, SCENARIO_WRITER_NAME
				, SCENARIO_MEMO
				, SCENARIO_DATE
				, SCENARIO_CATEGORY
			) values (
				  :UserId
				, :ScenarioTitle
				, :ScenarioSubtitle
				, :ScenarioWriterName
				, :ScenarioMemo
				, :SwNow
				, :ScenarioCategory
			);
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//日時は PHP 側の時刻を bind（SQLite の current_timestamp は UTC のため。MySQL でも同じ書式）
		$swNow = swDb_Now();
		$stmt->bindValue(':SwNow', $swNow, PDO::PARAM_STR);
		//パラメータ設定
		$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
		$stmt->bindParam(':ScenarioTitle', $valScenarioTitle, PDO::PARAM_STR);
		$stmt->bindParam(':ScenarioSubtitle', $valScenarioSubtitle, PDO::PARAM_STR);
		$stmt->bindParam(':ScenarioWriterName', $valScenarioWriterName, PDO::PARAM_STR);
		$stmt->bindParam(':ScenarioMemo', $valScenarioMemo, PDO::PARAM_STR);
		$stmt->bindParam(':ScenarioCategory', $valScenarioCategory, PDO::PARAM_INT);
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
	function clsSwScenarioDbUpdate($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valScenarioId = $this->ScenarioId;
		$valUserId = $this->UserId;
		$valScenarioTitle = $this->ScenarioTitle;
		$valScenarioSubtitle = $this->ScenarioSubtitle;
		$valScenarioWriterName = $this->ScenarioWriterName;
		$valScenarioMemo = $this->ScenarioMemo;
		$valScenarioDate = $this->ScenarioDate;
		$valScenarioCategory = $this->ScenarioCategory;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SCENARIO
				WHERE SCENARIO_ID = :ScenarioId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwScenario ->> NOT ENTRY!");
		}else{
			//UPDATE SQL
			$strSQL = <<<END_OF_SQL

			UPDATE SW_SCENARIO SET 
				  USER_ID = :UserId
				, SCENARIO_TITLE = :ScenarioTitle
				, SCENARIO_SUBTITLE = :ScenarioSubtitle
				, SCENARIO_WRITER_NAME = :ScenarioWriterName
				, SCENARIO_MEMO = :ScenarioMemo
				, SCENARIO_DATE = :SwNow
				, SCENARIO_CATEGORY = :ScenarioCategory
				WHERE SCENARIO_ID = :ScenarioId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//日時は PHP 側の時刻を bind（SQLite の current_timestamp は UTC のため。MySQL でも同じ書式）
			$swNow = swDb_Now();
			$stmt->bindValue(':SwNow', $swNow, PDO::PARAM_STR);
			//パラメータ設定
			$stmt->bindParam(':UserId', $valUserId, PDO::PARAM_INT);
			$stmt->bindParam(':ScenarioTitle', $valScenarioTitle, PDO::PARAM_STR);
			$stmt->bindParam(':ScenarioSubtitle', $valScenarioSubtitle, PDO::PARAM_STR);
			$stmt->bindParam(':ScenarioWriterName', $valScenarioWriterName, PDO::PARAM_STR);
			$stmt->bindParam(':ScenarioMemo', $valScenarioMemo, PDO::PARAM_STR);
			$stmt->bindParam(':ScenarioCategory', $valScenarioCategory, PDO::PARAM_INT);
			//パラメータのセット
			$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
			//EXECUTE
			$stmt->execute();
		}//end if
	}//end function

// -------------------------------------------------------------
//    DB更新　DELETE
// -------------------------------------------------------------
	function clsSwScenarioDbDelete($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valScenarioId = $this->ScenarioId;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SCENARIO
				WHERE SCENARIO_ID = :ScenarioId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwScenario ->> NOT ENTRY!");
		}else{
			//SYNARIO 削除
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_SCENARIO
				WHERE SCENARIO_ID = :ScenarioId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
			$stmt->execute();

			//SW_SCENE 削除
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_SCENE
				WHERE SCENARIO_ID = :ScenarioId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
			$stmt->execute();

			//SW_CHARACTER 削除
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_CHARACTER
				WHERE SCENARIO_ID = :ScenarioId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
			$stmt->execute();

			//SW_SYNOPSIS 削除
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_SYNOPSIS
				WHERE SCENARIO_ID = :ScenarioId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
			$stmt->execute();

			//SW_SCENARIO_LINES 削除
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_SCENARIO_LINES
				WHERE SCENARIO_ID = :ScenarioId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
			$stmt->execute();

		}//end if
	}//end function

// -------------------------------------------------------------
//    DB更新　COPY
// -------------------------------------------------------------
	function clsSwScenarioDbCopy($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valScenarioId = $this->ScenarioId;
		
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SCENARIO
				WHERE SCENARIO_ID = :ScenarioId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwScenario ->> NOT ENTRY!");
		}else{
			//新規シナリオ作成
			//DB から ﾃﾞｰﾀを取得しﾌﾟﾛﾊﾟﾃｨにｾｯﾄする
			$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SCENARIO
				WHERE SCENARIO_ID = :ScenarioId;
END_OF_SQL;

			$stmt = $mySqlConnObj->prepare($strSQL);
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			//パラメータのセット
			$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
			$stmt->execute();
			while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
				//$this->ScenarioId = '';
				$this->UserId = $myRow['USER_ID'];
				$this->ScenarioTitle = $myRow['SCENARIO_TITLE'].'のコピー';
				$this->ScenarioSubtitle = $myRow['SCENARIO_SUBTITLE'];
				$this->ScenarioWriterName = $myRow['SCENARIO_WRITER_NAME'];
				$this->ScenarioMemo = $myRow['SCENARIO_MEMO'];
				$this->ScenarioDate = '';
				$this->ScenarioCategory = $myRow['SCENARIO_CATEGORY'];
			}//end while
			
			//新規シナリオ作成
			$NewScenarioId = $this->clsSwScenarioDbInsert($mySqlConnObj);

			//SW_SCENE COPY
			$strSQL = <<<END_OF_SQL

			INSERT INTO SW_SCENE
					(SCENARIO_ID
					, SCENE_ORDER_NO
					, SCENE_VALID_CD
					, SCENE_NAME
					, SCENE_DESCRIPTION
					, SCENE_TIME_MIN
					, SCENE_TIME_SEC
					, COPY_SOURCE_ID)			
				SELECT 
					$NewScenarioId
					, SCENE_ORDER_NO
					, SCENE_VALID_CD
					, SCENE_NAME
					, SCENE_DESCRIPTION
					, SCENE_TIME_MIN
					, SCENE_TIME_SEC
					, SCENE_ID
				FROM SW_SCENE
				WHERE SCENARIO_ID = :ScenarioId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
			$stmt->execute();

			//SW_CHARACTER COPY
			$strSQL = <<<END_OF_SQL

			INSERT INTO SW_CHARACTER
				(SCENARIO_ID
				, CHARACTER_ORDER_NO
				, CHARACTER_NAME
				, CHARACTER_CHARA
				, COPY_SOURCE_ID)
			SELECT 
				  $NewScenarioId
				, CHARACTER_ORDER_NO
				, CHARACTER_NAME
				, CHARACTER_CHARA
				, CHARACTER_ID
				FROM	SW_CHARACTER
				WHERE SCENARIO_ID = :ScenarioId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
			$stmt->execute();

			//SW_SYNOPSIS COPY
			$strSQL = <<<END_OF_SQL

			INSERT INTO SW_SYNOPSIS
				(SCENARIO_ID,SYNOPSYS)
			SELECT
			$NewScenarioId
			, SYNOPSIS
			, ''
			FROM	SW_SYNOPSIS
				WHERE SCENARIO_ID = :ScenarioId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
			$stmt->execute();

			//SW_SCENARIO_LINES COPY
			$strSQL = <<<END_OF_SQL

			INSERT INTO SW_SCENARIO_LINES
				(SCENARIO_ID
				, SCENE_ID
				, SCENARIO_LINES_ORDER_NO
				, SCENARIO_TYPE
				, CHARACTER_ID
				, SCENARIO_LINES)
			SELECT
				$NewScenarioId
				, SCENE_ID
				, SCENARIO_LINES_ORDER_NO
				, SCENARIO_TYPE
				, CHARACTER_ID
				, SCENARIO_LINES
			FROM SW_SCENARIO_LINES
				WHERE SCENARIO_ID = :ScenarioId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
			$stmt->execute();
			
		//SW_SCENARIO_LINES UPDATE
			$strSQL = <<<END_OF_SQL

			UPDATE SW_SCENARIO_LINES
					, SW_SCENE
				SET SW_SCENARIO_LINES.SCENE_ID = SW_SCENE.SCENE_ID
				WHERE SW_SCENARIO_LINES.SCENE_ID = SW_SCENE.COPY_SOURCE_ID
				 	AND SW_SCENARIO_LINES.SCENARIO_ID = SW_SCENE.SCENARIO_ID
					AND SW_SCENARIO_LINES.SCENARIO_ID = $NewScenarioId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			$stmt->execute();

			//SW_SCENARIO_LINES UPDATE
			$strSQL = <<<END_OF_SQL

			UPDATE SW_SCENARIO_LINES
					, SW_CHARACTER
				SET SW_SCENARIO_LINES.CHARACTER_ID = SW_CHARACTER.CHARACTER_ID
				WHERE SW_SCENARIO_LINES.CHARACTER_ID = SW_CHARACTER.COPY_SOURCE_ID
				 	AND SW_SCENARIO_LINES.SCENARIO_ID = SW_CHARACTER.SCENARIO_ID
					AND SW_SCENARIO_LINES.SCENARIO_ID = $NewScenarioId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			$stmt->execute();
			
			
			
			
		}//end if
		return	"COPY";
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