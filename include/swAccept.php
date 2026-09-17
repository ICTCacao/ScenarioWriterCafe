<?php
// -------------------------------------------------------------------
//
//    セッション管理
//     swAccept.php
//
//  Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
// -------------------------------------------------------------------

  ini_set('session.gc_probability', 1);
  ini_set('session.gc_divisor', 1);
  ini_set('session.gc_maxlifetime', 6*60*60);
  ini_set('session.cookie_lifetime', 0);

  //ｾｯｼｮﾝ開始
  session_name('scenario-writer-cafe');
  session_start();

  //ｾｯｼｮﾝを継承する
  if (isset($_SESSION['swLoginId'])){
    //echo "SESSION ID 継承";
    if (isset($_SESSION['swLoginDate'])) {
      //LOGINした日時を取り出す
      $swLoginDate = $_SESSION['swLoginDate'];
      $swLoginTime = strtotime($swLoginDate);
      //現在日時
      $NowDateTime = date("Y-m-d H:i:s");
      $NowDateTime = strtotime($NowDateTime);
      //一定時間以上の場合は再ﾛｸﾞｲﾝが必要にする
      //経過時間（秒）
      $PastTime = $NowDateTime - $swLoginTime;
      if( $PastTime > _sw_access_max_ ){
        //ﾀﾞｲｱﾛｸﾞを表示し　ﾛｸﾞｲﾝﾌｫｰﾑ を表示する
        fncJavaAlert("TIME OUT{$PastTime}");
        exit;
      }else{
        //LoginIdを継承する
        $fdtUserLoginId = $_SESSION['swLoginId'];
        $fdtUserLoginDate = date("Y-m-d H:i:s");
        $_SESSION['swLoginDate'] = date("Y-m-d H:i:s");
      }
    }
  }else{
    //POSTされたﾛｸﾞｲﾝIDを取得
    if (isset($_POST['fdtUserLoginId'])) {
      $fdtUserLoginId = $_POST['fdtUserLoginId'];
    }else{
      //ﾀﾞｲｱﾛｸﾞを表示し　ﾛｸﾞｲﾝﾌｫｰﾑ を表示する
      fncJavaAlert('No ID');
      exit;
    }
    //POSTされたﾛｸﾞｲﾝ日時を取得
    if (isset($_POST['fdtUserLoginDate'])) {
      $fdtUserLoginDate = $_POST['fdtUserLoginDate'];
    }else{
      //ﾀﾞｲｱﾛｸﾞを表示し　ﾛｸﾞｲﾝﾌｫｰﾑ を表示する
      fncJavaAlert('No Date');
      exit;
    }
    //ｾｯｼｮﾝ情報取得
    if (isset($_SESSION['swLoginId'])) {
      $SessionLoginId = $_SESSION['swLoginId'];
    }else{
      //ﾀﾞｲｱﾛｸﾞを表示し　ﾛｸﾞｲﾝﾌｫｰﾑ を表示する
      fncJavaAlert('クッキーエラー');
      exit;
    }

    //ｾｯｼｮﾝのIDとPOSTされたIDを比較
    if( $fdtUserLoginId != $SessionLoginId ){
      //ﾀﾞｲｱﾛｸﾞを表示し　ﾛｸﾞｲﾝﾌｫｰﾑ を表示する
      fncJavaAlert('IDが違う');
      exit;
    }

    //一定時間以上の場合は再ﾛｸﾞｲﾝが必要にする
    //ﾛｸﾞｲﾝ日時
    $swLoginDate = $_SESSION['swLoginDate'];
    $swLoginTime = strtotime($swLoginDate);
    //現在日時
    $NowDateTime = date("Y-m-d H:i:s");
    $NowDateTime = strtotime($NowDateTime);
    //経過時間（秒）
    $PastTime = $NowDateTime - $swLoginTime;
    if( $PastTime > _sw_access_max_ ){
      //ﾀﾞｲｱﾛｸﾞを表示し　ﾛｸﾞｲﾝﾌｫｰﾑ を表示する
      fncJavaAlert('TIME OUT');
      exit;
    }
  }

// ------------------------------------------------------------------------------
//  ﾀﾞｲｱﾛｸﾞを表示し　ﾛｸﾞｲﾝﾌｫｰﾑ を表示する
// ------------------------------------------------------------------------------
function fncJavaAlert($Mes){

  $jumpURL = './swUserLogin.html';
  //ﾀﾞｲｱﾛｸﾞを表示し　ﾛｸﾞｲﾝﾌｫｰﾑ を表示する
  $AlertMsg = "ログインしてください".$Mes;

  print <<<END_OF_HTML
    <html>
      <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
      </hrad>
      <body>
               <Script language="JavaScript">
                  alert("$AlertMsg");
          document.location.replace("$jumpURL");
              </Script>
      </body>
    </html>
END_OF_HTML;
}


?>
