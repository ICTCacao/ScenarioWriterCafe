<?php
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//     シナリオ ﾃﾞｰﾀ管理ｸﾗｽ
//     clsSwScenarioLines
// -----------------------------------------------------------
class clsSwScenarioLines{
	var $ScenarioLinesId;            		//SCENARIO_LINES_ID
	var $ScenarioId;                    		//SCENARIO_ID
	var $SceneId;                        		//SCENE_ID
	var $ScenarioLinesOrderNo;  		//並び順
	var $ScenarioType;                		//シナリオ種別
	var $CharacterId;                  		//登場人物
	var $ScenarioLines;               		//台詞
// ｺﾝｽﾄﾗｸﾀ
    function clsfncSwScenarioLines(){
    }
// ﾌﾟﾛﾊﾟﾃｨ
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ScenarioLinesId
//    SCENARIO_LINES_ID を返す
// --------------------------------------
	function clsSwScenarioLinesGetScenarioLinesId(){
		return $this->ScenarioLinesId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ScenarioLinesId
//    SCENARIO_LINES_ID を設定する
// --------------------------------------
	function clsSwScenarioLinesSetScenarioLinesId($valScenarioLinesId){
		$this->ScenarioLinesId = $valScenarioLinesId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ScenarioId
//    SCENARIO_ID を返す
// --------------------------------------
	function clsSwScenarioLinesGetScenarioId(){
		return $this->ScenarioId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ScenarioId
//    SCENARIO_ID を設定する
// --------------------------------------
	function clsSwScenarioLinesSetScenarioId($valScenarioId){
		$this->ScenarioId = $valScenarioId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get SceneId
//    SCENE_ID を返す
// --------------------------------------
	function clsSwScenarioLinesGetSceneId(){
		return $this->SceneId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set SceneId
//    SCENE_ID を設定する
// --------------------------------------
	function clsSwScenarioLinesSetSceneId($valSceneId){
		$this->SceneId = $valSceneId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ScenarioLinesOrderNo
//    並び順 を返す
// --------------------------------------
	function clsSwScenarioLinesGetScenarioLinesOrderNo(){
		return $this->ScenarioLinesOrderNo;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ScenarioLinesOrderNo
//    並び順 を設定する
// --------------------------------------
	function clsSwScenarioLinesSetScenarioLinesOrderNo($valScenarioLinesOrderNo){
		$this->ScenarioLinesOrderNo = $valScenarioLinesOrderNo;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ScenarioType
//    シナリオ種別 を返す
// --------------------------------------
	function clsSwScenarioLinesGetScenarioType(){
		return $this->ScenarioType;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ScenarioType
//    シナリオ種別 を設定する
// --------------------------------------
	function clsSwScenarioLinesSetScenarioType($valScenarioType){
		$this->ScenarioType = $valScenarioType;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get CharacterId
//    登場人物 を返す
// --------------------------------------
	function clsSwScenarioLinesGetCharacterId(){
		return $this->CharacterId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set CharacterId
//    登場人物 を設定する
// --------------------------------------
	function clsSwScenarioLinesSetCharacterId($valCharacterId){
		$this->CharacterId = $valCharacterId;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Get ScenarioLines
//    台詞 を返す
// --------------------------------------
	function clsSwScenarioLinesGetScenarioLines(){
		return $this->ScenarioLines;
	}
// --------------------------------------
// ﾌﾟﾛﾊﾟﾃｨ Set ScenarioLines
//    台詞 を設定する
// --------------------------------------
	function clsSwScenarioLinesSetScenarioLines($valScenarioLines){
		$this->ScenarioLines = $valScenarioLines;
	}
// -------------------------------------------------------------
//    ｸﾗｽ初期化 ScenarioLinesId
// -------------------------------------------------------------
	function clsSwScenarioLinesInit($mySqlConnObj,$valScenarioLinesId){
		//ﾌﾟﾛﾊﾟﾃｨの初期化
		$this->ScenarioLinesId = '';           	//SCENARIO_LINES_ID
		$this->ScenarioId = '';                   	//SCENARIO_ID
		$this->SceneId = '';                       	//SCENE_ID
		$this->ScenarioLinesOrderNo = ''; 	//並び順
		$this->ScenarioType = '';               	//シナリオ種別
		$this->CharacterId = '';                 	//登場人物
		$this->ScenarioLines = '';              	//台詞
		//DB から ﾃﾞｰﾀを取得しﾌﾟﾛﾊﾟﾃｨにｾｯﾄする
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SCENARIO_LINES
				WHERE SCENARIO_LINES_ID = :ScenarioLinesId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':ScenarioLinesId', $valScenarioLinesId, PDO::PARAM_INT);
		$stmt->execute();
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$this->ScenarioLinesId = $myRow['SCENARIO_LINES_ID'];
			$this->ScenarioId = $myRow['SCENARIO_ID'];
			$this->SceneId = $myRow['SCENE_ID'];
			$this->ScenarioLinesOrderNo = $myRow['SCENARIO_LINES_ORDER_NO'];
			$this->ScenarioType = $myRow['SCENARIO_TYPE'];
			$this->CharacterId = $myRow['CHARACTER_ID'];
			$this->ScenarioLines = $myRow['SCENARIO_LINES'];
		}//end while
    }//end function
// -------------------------------------------------------------
//    ｸﾗｽ初期化ByOrderNo
// -------------------------------------------------------------
	function clsSwScenarioLinesInitByOrderNo($mySqlConnObj,$valScenarioId,$valSceneId,$valScenarioLinesOrderNo){
		//ﾌﾟﾛﾊﾟﾃｨの初期化
		$this->ScenarioLinesId = '';                 //SCENARIO_LINES_ID
		$this->ScenarioId = '';                      //SCENARIO_ID
		$this->SceneId = '';                         //SCENE_ID
		$this->ScenarioLinesOrderNo = '';            //並び順
		$this->ScenarioType = '';                    //シナリオ種別
		$this->CharacterId = '';                     //登場人物
		$this->ScenarioLines = '';                   //台詞
		//DB から ﾃﾞｰﾀを取得しﾌﾟﾛﾊﾟﾃｨにｾｯﾄする
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SCENARIO_LINES
				WHERE SCENARIO_ID = :ScenarioId
					AND SCENE_ID = :SceneId
					AND SCENARIO_LINES_ORDER_NO = :ScenarioLinesOrderNo;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
		$stmt->bindParam(':SceneId', $valSceneId, PDO::PARAM_INT);
		$stmt->bindParam(':ScenarioLinesOrderNo', $valScenarioLinesOrderNo, PDO::PARAM_INT);
		$stmt->execute();
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$this->ScenarioLinesId = $myRow['SCENARIO_LINES_ID'];
			$this->ScenarioId = $myRow['SCENARIO_ID'];
			$this->SceneId = $myRow['SCENE_ID'];
			$this->ScenarioLinesOrderNo = $myRow['SCENARIO_LINES_ORDER_NO'];
			$this->ScenarioType = $myRow['SCENARIO_TYPE'];
			$this->CharacterId = $myRow['CHARACTER_ID'];
			$this->ScenarioLines = $myRow['SCENARIO_LINES'];
		}//end while
    }//end function
// -------------------------------------------------------------
//    NextOrderNoを取得
// -------------------------------------------------------------
	function clsSwScenarioLinesGetMaxNextOrderNo($mySqlConnObj,$valScenarioId,$valSceneId){
		$NextOrderNo = 1;
		//DB から ﾃﾞｰﾀを取得しﾌﾟﾛﾊﾟﾃｨにｾｯﾄする
		$strSQL = <<<END_OF_SQL

		SELECT MAX(SCENARIO_LINES_ORDER_NO)	+ 1		AS	NEXT_ORDER_NO
			FROM SW_SCENARIO_LINES
				WHERE SCENARIO_ID = :ScenarioId
					AND SCENE_ID = :SceneId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
		$stmt->bindParam(':SceneId', $valSceneId, PDO::PARAM_INT);
		$stmt->execute();
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$NextOrderNo = $myRow['NEXT_ORDER_NO'];
		}//end while

		return	$NextOrderNo;
    }//end function

// -------------------------------------------------------------
//    DB更新　INSERT
// -------------------------------------------------------------
	function clsSwScenarioLinesDbInsert($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valScenarioLinesId = $this->ScenarioLinesId;
		$valScenarioId = $this->ScenarioId;
		$valSceneId = $this->SceneId;
		$valScenarioLinesOrderNo = $this->ScenarioLinesOrderNo;
		$valScenarioType = $this->ScenarioType;
		$valCharacterId = $this->CharacterId;
		$valScenarioLines = $this->ScenarioLines;
		
		//INSERT SQL
		$strSQL = <<<END_OF_SQL

		INSERT INTO SW_SCENARIO_LINES(
			  SCENARIO_ID
			, SCENE_ID
			, SCENARIO_LINES_ORDER_NO
			, SCENARIO_TYPE
			, CHARACTER_ID
			, SCENARIO_LINES
		) values (
			  :ScenarioId
			, :SceneId
			, :ScenarioLinesOrderNo
			, :ScenarioType
			, :CharacterId
			, :ScenarioLines
		);
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータ設定
		$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
		$stmt->bindParam(':SceneId', $valSceneId, PDO::PARAM_INT);
		$stmt->bindParam(':ScenarioLinesOrderNo', $valScenarioLinesOrderNo, PDO::PARAM_STR);
		$stmt->bindParam(':ScenarioType', $valScenarioType, PDO::PARAM_INT);
		$stmt->bindParam(':CharacterId', $valCharacterId, PDO::PARAM_INT);
		$stmt->bindParam(':ScenarioLines', $valScenarioLines, PDO::PARAM_STR);
		//EXECUTE
		$stmt->execute();
		//AUTO_INCREMENT値取得
		$LastInsertId = $mySqlConnObj->lastInsertId();
		//シナリオの並び順を整理する
		//$this->fncAdjustScenarioLinesOrderNo($mySqlConnObj,$valScenarioId,$valSceneId); 
		//AUTO_INCREMENT値を返す
		return $LastInsertId;
	}//end function

// -------------------------------------------------------------
//    DB更新　UPDATE
// -------------------------------------------------------------
	function clsSwScenarioLinesDbUpdate($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valScenarioLinesId = $this->ScenarioLinesId;
		$valScenarioId = $this->ScenarioId;
		$valSceneId = $this->SceneId;
		$valScenarioLinesOrderNo = $this->ScenarioLinesOrderNo;
		$valScenarioType = $this->ScenarioType;
		$valCharacterId = $this->CharacterId;
		$valScenarioLines = $this->ScenarioLines;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SCENARIO_LINES
				WHERE SCENARIO_LINES_ID = :ScenarioLinesId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':ScenarioLinesId', $valScenarioLinesId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwScenarioLines ->> NOT ENTRY! Update");
		}else{
			//UPDATE SQL
			$strSQL = <<<END_OF_SQL

			UPDATE SW_SCENARIO_LINES SET 
				  SCENARIO_ID = :ScenarioId
				, SCENE_ID = :SceneId
				, SCENARIO_LINES_ORDER_NO = :ScenarioLinesOrderNo
				, SCENARIO_TYPE = :ScenarioType
				, CHARACTER_ID = :CharacterId
				, SCENARIO_LINES = :ScenarioLines
				WHERE SCENARIO_LINES_ID = :ScenarioLinesId;
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータ設定
			$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
			$stmt->bindParam(':SceneId', $valSceneId, PDO::PARAM_INT);
			$stmt->bindParam(':ScenarioLinesOrderNo', $valScenarioLinesOrderNo, PDO::PARAM_STR);
			$stmt->bindParam(':ScenarioType', $valScenarioType, PDO::PARAM_INT);
			$stmt->bindParam(':CharacterId', $valCharacterId, PDO::PARAM_INT);
			$stmt->bindParam(':ScenarioLines', $valScenarioLines, PDO::PARAM_STR);
			//パラメータのセット
			$stmt->bindParam(':ScenarioLinesId', $valScenarioLinesId, PDO::PARAM_INT);
			//EXECUTE
			$stmt->execute();
			//シナリオの並び順を整理する
			//$this->fncAdjustScenarioLinesOrderNo($mySqlConnObj,$valScenarioId,$valSceneId); 
		}//end if
	}//end function

// -------------------------------------------------------------
//    DB更新　DELETE
// -------------------------------------------------------------
	function clsSwScenarioLinesDbDelete($mySqlConnObj){
		//ﾌﾟﾛﾊﾟﾃｨ取得
		$valScenarioLinesId = $this->ScenarioLinesId;
		$valScenarioId = $this->ScenarioId;
		$valSceneId = $this->SceneId;
		//登録確認
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SCENARIO_LINES
				WHERE SCENARIO_LINES_ID = :ScenarioLinesId;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		//パラメータのセット
		$stmt->bindParam(':ScenarioLinesId', $valScenarioLinesId, PDO::PARAM_INT);
		$stmt->execute();
		//件数取得
		$myRowCnt = $stmt->rowCount();
		if($myRowCnt == 0 ){
			echo $this->fncAlert("clsSwScenarioLines ->> NOT ENTRY!");
		}else{
			//DELETE SQL
			$strSQL = <<<END_OF_SQL

			DELETE FROM SW_SCENARIO_LINES
				WHERE SCENARIO_LINES_ID = '$valScenarioLinesId';
END_OF_SQL;
			$stmt = $mySqlConnObj->prepare($strSQL);
			//パラメータのセット
			$stmt->bindParam(1, $valScenarioLinesId, PDO::PARAM_INT);
			$stmt->execute();
			//シナリオの並び順を整理する
			//$this->fncAdjustScenarioLinesOrderNo($mySqlConnObj,$valScenarioId,$valSceneId); 
		}//end if
	}//end function
// -------------------------------------------------------------
//    シナリオの並び順を整理する
// -------------------------------------------------------------
	function fncAdjustScenarioLinesOrderNo($mySqlConnObj,$valScenarioId,$valSceneId){
		//並び順を初期化
		$LinesOrderNo = 0;
		//更新オブジェクトを準備する
		$strUpdSQL = <<<END_OF_SQL
			
			UPDATE SW_SCENARIO_LINES SET
				SCENARIO_LINES_ORDER_NO = :LinesOrderNo
				WHERE SCENARIO_LINES_ID = :ScenarioLinesId;
END_OF_SQL;
		$upd_stmt = $mySqlConnObj->prepare($strUpdSQL);
		//パラメータ設定
		$upd_stmt->bindParam(':LinesOrderNo', $LinesOrderNo, PDO::PARAM_INT);
		$upd_stmt->bindParam(':ScenarioLinesId', $ScenarioLinesId, PDO::PARAM_INT);

		//シーンのシナリオを検索
		$strSQL = <<<END_OF_SQL

		SELECT * FROM SW_SCENARIO_LINES
				WHERE SCENARIO_ID = :ScenarioId
					AND SCENE_ID = :SceneId
				ORDER BY SCENARIO_LINES_ORDER_NO;
END_OF_SQL;
		$stmt = $mySqlConnObj->prepare($strSQL);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		//パラメータのセット
		$stmt->bindParam(':ScenarioId', $valScenarioId, PDO::PARAM_INT);
		$stmt->bindParam(':SceneId', $valSceneId, PDO::PARAM_INT);
		$stmt->execute();
		while($myRow = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$LinesOrderNo = $LinesOrderNo + 100;
			$ScenarioLinesId = $myRow['SCENARIO_LINES_ID'];
			$ScenarioLinesOrderNo = $myRow['SCENARIO_LINES_ORDER_NO'];
			
			if( $ScenarioLinesOrderNo != $LinesOrderNo){
				//更新オブジェクト実行
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