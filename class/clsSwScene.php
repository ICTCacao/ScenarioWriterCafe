<?php
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//     場面設定 ﾃﾞｰﾀ管理ｸﾗｽ
//     clsSwScene
// -----------------------------------------------------------
class clsSwScene{
	var $SceneId;                         //SCENE_ID
	var $ScenarioId;                      //SCENARIO_ID
	var $SceneOrderNo;                    //場面順番
	var $SceneValidCd;                    //有効
	var $SceneName;                       //場面名称
	var $SceneDescription;                //場面説明
	var $SceneTimeMin;                    //時間（分）
	var $SceneTimeSec;                    //時間（秒）
// ｺﾝｽﾄﾗｸﾀ
    function clsfncSwScene(){
    }
// ﾌﾟﾛﾊﾟﾃｨ
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get SceneId
//    SCENE_ID を返す
// --------------------------------------
	function clsSwSceneGetSceneId(){
		return $this->SceneId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set SceneId
//    SCENE_ID を設定する
// --------------------------------------
	function clsSwSceneSetSceneId($valSceneId){
		$this->SceneId = $valSceneId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ScenarioId
//    SCENARIO_ID を返す
// --------------------------------------
	function clsSwSceneGetScenarioId(){
		return $this->ScenarioId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ScenarioId
//    SCENARIO_ID を設定する
// --------------------------------------
	function clsSwSceneSetScenarioId($valScenarioId){
		$this->ScenarioId = $valScenarioId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get SceneOrderNo
//    場面順番 を返す
// --------------------------------------
	function clsSwSceneGetSceneOrderNo(){
		return $this->SceneOrderNo;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set SceneOrderNo
//    場面順番 を設定する
// --------------------------------------
	function clsSwSceneSetSceneOrderNo($valSceneOrderNo){
		$this->SceneOrderNo = $valSceneOrderNo;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get SceneValidCd
//    有効 を返す
// --------------------------------------
	function clsSwSceneGetSceneValidCd(){
		return $this->SceneValidCd;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set SceneValidCd
//    有効 を設定する
// --------------------------------------
	function clsSwSceneSetSceneValidCd($valSceneValidCd){
		$this->SceneValidCd = $valSceneValidCd;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get SceneName
//    場面名称 を返す
// --------------------------------------
	function clsSwSceneGetSceneName(){
		return $this->SceneName;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set SceneName
//    場面名称 を設定する
// --------------------------------------
	function clsSwSceneSetSceneName($valSceneName){
		$this->SceneName = $valSceneName;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get SceneDescription
//    場面説明 を返す
// --------------------------------------
	function clsSwSceneGetSceneDescription(){
		return $this->SceneDescription;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set SceneDescription
//    場面説明 を設定する
// --------------------------------------
	function clsSwSceneSetSceneDescription($valSceneDescription){
		$this->SceneDescription = $valSceneDescription;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get SceneTimeMin
//    時間（分） を返す
// --------------------------------------
    function clsSwSceneGetSceneTimeMin(){
        return $this->SceneTimeMin;
    }
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set SceneTimeMin
//    時間（分） を設定する
// --------------------------------------
    function clsSwSceneSetSceneTimeMin($valSceneTimeMin){
        $this->SceneTimeMin = $valSceneTimeMin;
    }
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get SceneTimeSec
//    時間（秒） を返す
// --------------------------------------
    function clsSwSceneGetSceneTimeSec(){
        return $this->SceneTimeSec;
    }
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set SceneTimeSec
//    時間（秒） を設定する
// --------------------------------------
    function clsSwSceneSetSceneTimeSec($valSceneTimeSec){
        $this->SceneTimeSec = $valSceneTimeSec;
    }
// -------------------------------------------------------------
//    ｸﾗｽ初期化
// -------------------------------------------------------------
	function clsSwSceneInit($mySqlConnObj,$valSceneId){
		//ﾌﾟﾛﾊﾟﾃｨの初期化
		$this->SceneId = '';                         //SCENE_ID
		$this->ScenarioId = '';                      //SCENARIO_ID
		$this->SceneOrderNo = '';                    //場面順番
		$this->SceneValidCd = '';                    //有効
		$this->SceneName = '';                       //場面名称
		$this->SceneDescription = '';                //場面説明
		$this->SceneTimeMin = '';                    //時間（分）
		$this->SceneTimeSec = '';                    //時間（秒）
		//DB から ﾃﾞｰﾀを取得しﾌﾟﾛﾊﾟﾃｨにｾｯﾄする
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SCENE
				WHERE SCENE_ID = :SceneId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':SceneId', $valSceneId, PDO::PARAM_INT);
		$stmt->execute();
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$this->SceneId = $myRow['SCENE_ID'];
			$this->ScenarioId = $myRow['SCENARIO_ID'];
			$this->SceneOrderNo = $myRow['SCENE_ORDER_NO'];
			$this->SceneValidCd = $myRow['SCENE_VALID_CD'];
			$this->SceneName = $myRow['SCENE_NAME'];
			$this->SceneDescription = $myRow['SCENE_DESCRIPTION'];
			$this->SceneTimeMin = $myRow['SCENE_TIME_MIN'];
			$this->SceneTimeSec = $myRow['SCENE_TIME_SEC'];
		}//end while
    }//end function

// -------------------------------------------------------------
//    DB更新　INSERT
// -------------------------------------------------------------
	function clsSwSceneDbInsert($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valSceneId = $this->SceneId;
		$valScenarioId = $this->ScenarioId;
		$valSceneOrderNo = $this->SceneOrderNo;
		$valSceneValidCd = $this->SceneValidCd;
		$valSceneName = $this->SceneName;
		$valSceneDescription = $this->SceneDescription;
		$valSceneTimeMin = $this->SceneTimeMin;
		$valSceneTimeSec = $this->SceneTimeSec;
		//INSERT SQL
		$strSQL = <<<END_OF_SQL

		INSERT INTO SW_SCENE(
			  SCENARIO_ID
			, SCENE_ORDER_NO
			, SCENE_VALID_CD
			, SCENE_NAME
			, SCENE_DESCRIPTION
			, SCENE_TIME_MIN
			, SCENE_TIME_SEC
		) values (
			  :ScenarioId
			, :SceneOrderNo
			, :SceneValidCd
			, :SceneName
			, :SceneDescription
			, :SceneTimeMin
			, :SceneTimeSec
		);
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータ設定
		$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
		$stmt->bindParam(':SceneOrderNo', $valSceneOrderNo, PDO::PARAM_INT);
		$stmt->bindParam(':SceneValidCd', $valSceneValidCd, PDO::PARAM_INT);
		$stmt->bindParam(':SceneName', $valSceneName, PDO::PARAM_STR);
		$stmt->bindParam(':SceneDescription', $valSceneDescription, PDO::PARAM_STR);
		$stmt->bindParam(':SceneTimeMin', $valSceneTimeMin, PDO::PARAM_INT);
		$stmt->bindParam(':SceneTimeSec', $valSceneTimeSec, PDO::PARAM_INT);
		//EXECUTE
		$stmt->execute();
		//AUTO_INCREMENT値取得
		$LastInsertId = $mySqlConnObj->lastInsertId();
		//場面の並び順を整理する
		//$this->fncAdjustSceneOrderNo($mySqlConnObj,$valScenarioId); 

		//AUTO_INCREMENT値を返す
		return $LastInsertId;
	}//end function

// -------------------------------------------------------------
//    DB更新　UPDATE
// -------------------------------------------------------------
	function clsSwSceneDbUpdate($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valSceneId = $this->SceneId;
		$valScenarioId = $this->ScenarioId;
		$valSceneOrderNo = $this->SceneOrderNo;
		$valSceneValidCd = $this->SceneValidCd;
		$valSceneName = $this->SceneName;
		$valSceneDescription = $this->SceneDescription;
		$valSceneTimeMin = $this->SceneTimeMin;
		$valSceneTimeSec = $this->SceneTimeSec;

		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SCENE
				WHERE SCENE_ID = :SceneId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':SceneId', $valSceneId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwScene ->> NOT ENTRY!");
		}else{
			//UPDATE SQL
			$strSQL = <<<END_OF_SQL

			UPDATE SW_SCENE SET 
				  SCENARIO_ID = :ScenarioId
				, SCENE_ORDER_NO = :SceneOrderNo
				, SCENE_VALID_CD = :SceneValidCd
				, SCENE_NAME = :SceneName
				, SCENE_DESCRIPTION = :SceneDescription
				, SCENE_TIME_MIN = :SceneTimeMin
				, SCENE_TIME_SEC = :SceneTimeSec
				WHERE SCENE_ID = :SceneId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータ設定
			$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
			$stmt->bindParam(':SceneOrderNo', $valSceneOrderNo, PDO::PARAM_INT);
			$stmt->bindParam(':SceneValidCd', $valSceneValidCd, PDO::PARAM_INT);
			$stmt->bindParam(':SceneName', $valSceneName, PDO::PARAM_STR);
			$stmt->bindParam(':SceneDescription', $valSceneDescription, PDO::PARAM_STR);
			$stmt->bindParam(':SceneTimeMin', $valSceneTimeMin, PDO::PARAM_INT);
			$stmt->bindParam(':SceneTimeSec', $valSceneTimeSec, PDO::PARAM_INT);
			//パラメータのセット
			$stmt->bindParam(':SceneId', $valSceneId, PDO::PARAM_INT);
			//EXECUTE
			$stmt->execute();
			//場面の並び順を整理する
			//$this->fncAdjustSceneOrderNo($mySqlConnObj,$valScenarioId); 
			
		}//end if
	}//end function

// -------------------------------------------------------------
//    DB更新　DELETE
// -------------------------------------------------------------
	function clsSwSceneDbDelete($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valSceneId = $this->SceneId;
		$valScenarioId = $this->ScenarioId;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SCENE
				WHERE SCENE_ID = '$valSceneId';
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(1, $valSceneId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwScene ->> NOT ENTRY!");
		}else{
			//DELETE SQL
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_SCENE
				WHERE SCENE_ID = :SceneId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			//パラメータのセット
			$stmt->bindParam(':SceneId', $valSceneId, PDO::PARAM_INT);
			$stmt->execute();
			//場面の並び順を整理する
			//$this->fncAdjustSceneOrderNo($mySqlConnObj,$valScenarioId); 

		}//end if
	}//end function

// -------------------------------------------------------------
//    場面の並び順を整理する
// -------------------------------------------------------------
	function fncAdjustSceneOrderNo($mySqlConnObj,$valScenarioId){
		//並び順初期化
		$CharaOrderNo = 0;
		//更新オブジェクトを準備する
		$strUpdSQL = <<<END_OF_SQL
			UPDATE SW_SCENE SET
				SCENE_ORDER_NO = :SceneOrderNo
				WHERE SCENE_ID = :SceneId;
END_OF_SQL;
		$upd_stmt = $mySqlConnObj->prepare($strUpdSQL);
		//パラメータ設定
		$upd_stmt->bindParam(':SceneOrderNo', $SceneOrderNo, PDO::PARAM_INT);
		$upd_stmt->bindParam(':SceneId', $SceneId, PDO::PARAM_INT);

		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SCENE
				WHERE SCENARIO_ID = :ScenarioId
				ORDER BY SCENE_ORDER_NO;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
		$stmt->execute();
		//更新する
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$SceneOrderNo = $SceneOrderNo + 100;
			$SceneId = $myRow['SCENE_ID'];
			$OldSceneOrderNo = $myRow['SCENE_ORDER_NO'];
			
			if( $OldSceneOrderNo != $SceneOrderNo){
				//EXECUTE
				$upd_stmt->execute();
			}
		}//end while
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