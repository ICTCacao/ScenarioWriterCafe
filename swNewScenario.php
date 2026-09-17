<?php
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//     SW_SCENARIO I/O ｼｽﾃﾑ
//
//     SwScenario.php
// -----------------------------------------------------------
// ------------------------------------------------------------------------------
  //定数読み込み
  include_once("./sw_config/swConstant.php");
  //DB接続ｸﾗｽの初期化
  include_once("./include/ConnectMySQL.php");
// ------------------------------------------------------------------------------
  //ｾｯｼｮﾝ管理
  include_once("./include/swAccept.php");
  //管理者チェック
  include_once("./include/swCheckAdmin.php");
// ------------------------------------------------------------------------------
  //ﾃﾞﾌｫﾙﾄｱｸｼｮﾝ
  $ThisPHP = 'swNewScenario.php';

  //共通関数をｲﾝｸﾙｰﾄﾞ
  include_once("./include/swFunc.php");
  //管理者ｾｯｼｮﾝ管理
  include_once("./include/swAccept.php");

  // ﾍｯﾀﾞ表示
  $HtmlTitle = "新規シナリオ";
  include_once("./include/swHeader.php");

  //ﾌｫｰﾑのﾃﾞｰﾀを読み込む
  fncGetPostItems();

  //MainProcedure
  fncMainProc($mySqlConnObj);

  exit();

// ------------------------------------------------------------------------------
//      POSTされた要素を取得
//          fncGetPostItems()
// ------------------------------------------------------------------------------
function fncGetPostItems(){
  //共通global変数
  global  $fdtUserLoginId,$fdtUserLoginDate;
  //POSTされたログイン要素を取得
  $fdtUserLoginId = swFunc_GetPostData('fdtUserLoginId');          //USERログインID
  $fdtUserLoginDate = swFunc_GetPostData('fdtUserLoginDate');      //USERログイン日時

}//end function

// ------------------------------------------------------------------------------
//      MAIN PROCEDURE
//          fncMainProc($mySqlConnObj)
// ------------------------------------------------------------------------------
function fncMainProc($mySqlConnObj){
  //ﾌｫｰﾑの表示
  fncMainForm($mySqlConnObj);
}//end function

// ------------------------------------------------------------------------------
//      MAIN FORM
//          fncMainForm($mySqlConnObj)
// ------------------------------------------------------------------------------
function fncMainForm($mySqlConnObj){
  global  $ThisPHP,$SubmitMode;
  //global 変数
  global  $fdtScenarioId;
  global  $fdtUserId;
  global  $fdtScenarioTitle;
  global  $fdtScenarioSubtitle;
  global  $fdtScenarioWriterName;
  global  $fdtScenarioMemo;
  global  $fdtScenarioDate;
  global  $fdtScenarioCategory;
  global  $fdtUserLoginId,$fdtUserLoginDate;
  //ログイン情報からユーザー情報を取得
  //ﾃﾞｰﾀ管理ｸﾗｽ ﾛｸﾞｲﾝ情報
  include_once("./class/clsSwUserLoginInfo.php");
  $clsSwUserLoginInfo = new clsSwUserLoginInfo();
  //ﾃﾞｰﾀ管理ｸﾗｽの初期化
  $clsSwUserLoginInfo->clsSwUserLoginInfoInit($mySqlConnObj,$fdtUserLoginId);
  //ﾌﾟﾛﾊﾟﾃｨGet
  $fdtUserId = $clsSwUserLoginInfo->clsSwUserLoginInfoGetUserId();                    //USER_ID
  $fdtUserLoginDate = $clsSwUserLoginInfo->clsSwUserLoginInfoGetUserLoginDate();      //USERログイン日時

  //ﾃﾞｰﾀ管理ｸﾗｽ ﾕｰｻﾞ情報
  include_once("./class/clsSwUser.php");
  $clsSwUser = new clsSwUser();
  //ﾃﾞｰﾀ管理ｸﾗｽの初期化
  $clsSwUser->clsSwUserInit($mySqlConnObj,$fdtUserId);
  //ﾌﾟﾛﾊﾟﾃｨGet
  $fdtUserName = $clsSwUser->clsSwUserGetUserName();                //ユーザー名
  $fdtUserMaxScenario = $clsSwUser->clsSwUserGetUserMaxScenario();  //作成可能シナリオ数

  $fdtScenarioWriterName = $fdtUserName;

  //css powerd by Bootstrap ver3
  include_once("./include/swMenuBar.php");

  //新規シナリオ作成可能か判定
  //ﾃﾞｰﾀ管理ｸﾗｽ シナリオ情報
  include_once("./class/clsSwScenario.php");
  $clsSwScenario = new clsSwScenario();
  //登録されているシナリオ数を取得する
  $ScenarioCnt = $clsSwScenario->clsSwScenarioCount($mySqlConnObj,$fdtUserId);

  //当分の間登録無制限にする
  $fdtUserMaxScenario = '99999';

  //ゲストチェック
  if(SW_GUEST){
    //ゲスト機能制限
    $fdtUserMaxScenario = '1';
  }


  if( $ScenarioCnt >= $fdtUserMaxScenario){
    //新規シナリオ作成できない
    swMenuBar_Print('./include/swDropDownMenu.php', 'frmSwScenario', '新規シナリオ', array(), $fdtUserName, 'シナリオ作成可能数の上限に達しています');
    print <<<END_OF_HTML
      <!-- ﾒﾆｭｰ 制御ﾎﾞﾀﾝ 表示ROW ここまで-->
    <!-- main -->
    <div class="scenarioedit">
      <div class="container">
          <!-- ﾌｫｰﾑ と ﾘｽﾄ -->
          <div class="row row-0">
            <div class="col-sm-11 row-0">
              <div class="edit-jumbotron">
                <form class="" role="form" name="frmSwScenario" id="frmSwScenario" method="POST" action="">
                  <input type="hidden" name="SubmitMode" id="SubmitMode" value="$SubmitMode">
                  <input type="hidden" name="fdtUserLoginId" id="fdtUserLoginId" value="$fdtUserLoginId">
                  <input type="hidden" name="fdtUserLoginDate" id="fdtUserLoginDate" value="$fdtUserLoginDate">

                  <div class="col-sm-12 offset-sm-1 text-start">

                      <h3>シナリオ作成可能数は、{$fdtUserMaxScenario}作品に設定されています。</h3>
                      <hr>
                      <h4>すでに{$ScenarioCnt}作品が登録されているため、新しいシナリオを作成することはできません。</h4>

                  </div>

                </form>
END_OF_HTML;
  }else{
    //新規シナリオ作成可能
    $fdtScenarioTitle = '名称未設定';
    swMenuBar_Print('./include/swDropDownMenu.php', 'frmSwScenario', '新規シナリオ', array(
      array('label'=>'新規シナリオ登録', 'onclick'=>"fncNewSwScenarioInsert(frmSwScenario,'INSERT','TRUE','新規シナリオ登録');"),
    ), $fdtUserName);
    print <<<END_OF_HTML

      <!-- ﾒﾆｭｰ 制御ﾎﾞﾀﾝ 表示ROW ここまで-->
    <!-- main -->
    <div class="scenarioedit">
      <div class="container">
          <!-- ﾌｫｰﾑ と ﾘｽﾄ -->
          <div class="row row-0">
            <div class="col-sm-11 row-0">
              <div class="edit-jumbotron">
                <form class="" role="form" name="frmSwScenario" id="frmSwScenario" method="POST" action="$ThisPHP">
                  <input type="hidden" name="SubmitMode" id="SubmitMode" value="$SubmitMode">
                  <input type="hidden" name="fdtUserLoginId" id="fdtUserLoginId" value="$fdtUserLoginId">
                  <input type="hidden" name="fdtUserLoginDate" id="fdtUserLoginDate" value="$fdtUserLoginDate">

                  <div class="row row-0">
                    <label for="fdtScenarioTitle" class="col-form-label col-sm-2">タイトル</label>
                    <div class="col-sm-8">
                      <input type="text"
                          class="form-control form-control-sm"
                          id="fdtScenarioTitle" name="fdtScenarioTitle"
                          value="$fdtScenarioTitle"
                          placeholder="タイトル">
                    </div>
                  </div>
                  <div class="row row-0">
                    <label for="fdtScenarioSubtitle" class="col-form-label col-sm-2">サブタイトル</label>
                    <div class="col-sm-8">
                      <input type="text"
                          class="form-control form-control-sm"
                          id="fdtScenarioSubtitle" name="fdtScenarioSubtitle"
                          value="$fdtScenarioSubtitle"
                          placeholder="サブタイトル">
                    </div>
                  </div>
                  <div class="row row-0">
                    <label for="fdtScenarioWriterName" class="col-form-label col-sm-2">作者名</label>
                    <div class="col-sm-8">
                      <input type="text"
                          class="form-control form-control-sm"
                          id="fdtScenarioWriterName" name="fdtScenarioWriterName"
                          value="$fdtScenarioWriterName"
                          placeholder="作者名">
                    </div>
                  </div>
                  <div class="row row-0">
                    <label for="fdtScenarioWriterName" class="col-form-label col-sm-2">分類</label>
                    <div class="col-sm-4">
END_OF_HTML;

  //分類SELECT BOX
  //CSVﾃﾞｰﾀからselect box を作成する
  $csvArray = swFunc_MakeSelectItemsCsvScenarioCategory();
  $ObjName = "fdtScenarioCategory";    //select box の名称.ID
  $default = $fdtScenarioCategory;    //ﾃﾞﾌｫﾙﾄ値
  $onChange = '';          //onChange で起動する javascript or jQuery
  $ViewCode = FALSE;        //ｺｰﾄﾞを表示する場合はTRUE
  //SelectBoxHtml出力
  $SelectBoxScenarioCategoryHtml = swFunc_MakeSelectBox($ObjName,$csvArray,$default,$onChange,$ViewCode);

  print <<<END_OF_HTML

                      $SelectBoxScenarioCategoryHtml
                    </div>
                  </div>
                  <div class="row row-0">
                    <label for="fdtScenarioMemo" class="col-form-label col-sm-2">メモ</label>
                    <div class="col-sm-8">
                      <textarea placeholder="メモ"
                          class="form-control form-control-sm"
                          id="fdtScenarioMemo" name="fdtScenarioMemo"
                          rows="3">$fdtScenarioMemo</textarea>
                    </div>
                  </div>
END_OF_HTML;

  //------------------------------------------------------------
  //CSVﾃﾞｰﾀ
  $csvArray = array();
  for( $i = 1 ; $i <= 50 ;$i++ ){
    array_push($csvArray,$i.":".$i);
  }
  //CSVﾃﾞｰﾀからselect box を作成する
  $ObjName = "fdtMakuSuu";    //select box の名称.ID
  $default = "1";    //ﾃﾞﾌｫﾙﾄ値
  $onChange = '';          //onChange で起動する javascript or jQuery
  $ViewCode = FALSE;        //ｺｰﾄﾞを表示する場合はTRUE
  //SelectBoxHtml出力
  $SelectBoxMakuSuuHtml = swFunc_MakeSelectBox($ObjName,$csvArray,$default,$onChange,$ViewCode);

  //CSVﾃﾞｰﾀからselect box を作成する
  $ObjName = "fdtBaSuu";    //select box の名称.ID
  $default = "1";    //ﾃﾞﾌｫﾙﾄ値
  $onChange = '';          //onChange で起動する javascript or jQuery
  $ViewCode = FALSE;        //ｺｰﾄﾞを表示する場合はTRUE
  //SelectBoxHtml出力
  $SelectBoxBaSuuHtml = swFunc_MakeSelectBox($ObjName,$csvArray,$default,$onChange,$ViewCode);
  //------------------------------------------------------------



    print <<<END_OF_HTML
                  <hr>
                  <div class="row row-0">
                    <label for="fdtScenarioMemo" class="col-form-label col-sm-2">場面設定</label>
                    <div class="col-sm-1">
                      <input type="text"
                          class="form-control form-control-sm text-end"
                          id="fdtBeforeAddMakuName" name="fdtBeforeAddMakuName"
                          value="第"
                          placeholder="">
                    </div>
                    <div class="col-sm-1">
                      $SelectBoxMakuSuuHtml
                    </div>
                    <div class="col-sm-1">
                      <input type="text"
                          class="form-control form-control-sm text-end"
                          id="fdtAfterAddMakuName" name="fdtAfterAddMakuName"
                          value="幕"
                          placeholder="">
                    </div>
                    <div class="col-sm-1">
                      <input type="text"
                          class="form-control form-control-sm text-end"
                          id="fdtBeforeAddBaName" name="fdtBeforeAddBaName"
                          value="ー"
                          placeholder="">
                    </div>
                    <div class="col-sm-1">
                      $SelectBoxBaSuuHtml
                    </div>
                    <div class="col-sm-1">
                      <input type="text"
                          class="form-control form-control-sm text-end"
                          id="fdtAfterAddBaName" name="fdtAfterAddBaName"
                          value="場"
                          placeholder="">
                    </div>
                    <div class="col-sm-2 text-center">
                      <h5>
                      <span id="SceneSuu"></span>
                      </h5>
                    </div>
                  </div>
                  <div class="row row-0">
                    <div class="col-sm-10 text-end">
                      <input type="hidden" name="fdtScenarioDate" id="fdtScenarioDate" value="$fdtScenarioDate">
                    </div>
                  </div>

END_OF_HTML;

  //------------------------------------------------------------
  //CSVﾃﾞｰﾀ
  $csvArray = array();
  for( $i = 1 ; $i <= 25 ;$i++ ){
    array_push($csvArray,$i.":".$i);
  }
  //CSVﾃﾞｰﾀからselect box を作成する
  $ObjName = "fdtCaraSuu";    //select box の名称.ID
  $default = "1";    //ﾃﾞﾌｫﾙﾄ値
  $onChange = '';          //onChange で起動する javascript or jQuery
  $ViewCode = FALSE;        //ｺｰﾄﾞを表示する場合はTRUE
  //SelectBoxHtml出力
  $SelectBoxCaraSuuHtml = swFunc_MakeSelectBox($ObjName,$csvArray,$default,$onChange,$ViewCode);
  //------------------------------------------------------------
    print <<<END_OF_HTML
                  <hr>
                  <div class="row row-0">
                    <label for="fdtScenarioMemo" class="col-form-label col-sm-2">登場人物</label>
                    <div class="col-sm-2">
                      <input type="text"
                          class="form-control form-control-sm text-end"
                          id="fdtAfterAddCaraName" name="fdtAfterAddCaraName"
                          value="登場人物"
                          placeholder="">
                    </div>
                    <div class="col-sm-1">
                      $SelectBoxCaraSuuHtml
                    </div>
                  </div>
END_OF_HTML;


    print <<<END_OF_HTML
                  <div class="row row-0">
                    <div class="col-sm-10 text-end">
                      <input type="hidden" name="fdtScenarioDate" id="fdtScenarioDate" value="$fdtScenarioDate">
                    </div>
                  </div>
                  <span id="retMsg"></span>
                </form>
END_OF_HTML;
    }



    print <<<END_OF_HTML

              </div><!--jumbotron -->
            </div><!--col-sm-11 row-0 -->
          </div><!--row row-0 -->
      </div><!--container -->
    </div><!--scenarioedit-->

  <script type="text/javascript" src="./ajax/ajaxNewSwScenario.js"></script>
  <script>
    autosize(document.querySelectorAll('textarea'));
  </script>

  </body>
</html>

END_OF_HTML;

}//end function



// -----------------------------------------------------------
?>
