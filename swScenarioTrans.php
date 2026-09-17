<?php
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
//
//     旧バージョン（CGI 版）のデータを取り込む
//
//     swScenarioTrans.php
//
//     2026-09 書き直し
//       ・LOAD DATA LOCAL INFILE（MySQL 専用）をやめ、クラス経由の INSERT にした。SQLite でも動く。
//       ・取込先はログインしているユーザー（旧コードは USER_ID=3 固定だった）。
//       ・まず内容を一覧表示し、「取り込む」ボタンで実行する（誤って開いても何も変わらない）。
//       ・台詞や名前にカンマがあっても崩れない（フィールド数で分割）。
//       ・文字コードは SJIS-win（CP932）として読む。
//       ・synop.cgi があればシノプシスとして取り込む。
//       ・1 シナリオずつトランザクション。途中で失敗したらそのシナリオは取り消す。
//
//     元データの置き場所: ./ScenarioFolder/
//       Scenario_index.cgi            旧シナリオID,タイトル[,以降は無視（旧版のパス等）]
//       <旧シナリオID>/character.cgi   旧登場人物ID,並び順,名前,説明
//       <旧シナリオID>/scene.cgi       旧場面ID,並び順,場面名,場面説明
//       <旧シナリオID>/<旧場面ID>.cgi   旧台詞ID,並び順,種別(0=台詞 1=ト書 3=歌詞),旧登場人物ID|none,本文
//       <旧シナリオID>/synop.cgi       シノプシス（任意・テキスト）
//
// ------------------------------------------------------------------------------
  //定数読み込み
  include_once("./sw_config/swConstant.php");
  //DB接続
  include_once("./include/ConnectMySQL.php");
// ------------------------------------------------------------------------------
  //ｾｯｼｮﾝ管理
  include_once("./include/swAccept.php");
  //ログインユーザー取得（$fdtUserId, $fdtUserName）
  include_once("./include/swCheckAdmin.php");
// ------------------------------------------------------------------------------
  //共通関数
  include_once("./include/swFunc.php");
  include_once("./include/swMenuBar.php");
  //ﾃﾞｰﾀ管理ｸﾗｽ
  include_once("./class/clsSwScenario.php");
  include_once("./class/clsSwCharacter.php");
  include_once("./class/clsSwScene.php");
  include_once("./class/clsSwScenarioLines.php");
  include_once("./class/clsSwSynopsis.php");

  $ThisPHP = 'swScenarioTrans.php';
  $swTransFolder = './ScenarioFolder';

  // ﾍｯﾀﾞ表示
  $HtmlTitle = "旧データの取り込み";
  include_once("./include/swHeader.php");

  //処理時間無制限
  set_time_limit(0);

  $SubmitMode = swFunc_GetPostData('SubmitMode');

  //元データを走査
  $plan = swTrans_Scan($swTransFolder);

  swMenuBar_Print('./include/swDropDownMenu.php', 'frmSwTrans', '旧データの取り込み', array(), $fdtUserName);
  print '<div class="container" style="max-width: 960px; margin-top: 80px;">';
  print '<form name="frmSwTrans" id="frmSwTrans" method="post" action="' . h($ThisPHP) . '">';
  print '<input type="hidden" name="fdtUserLoginId" value="' . h($fdtUserLoginId) . '">';
  print '<input type="hidden" name="fdtUserLoginDate" value="' . h($fdtUserLoginDate) . '">';
  print '<input type="hidden" name="SubmitMode" id="SubmitMode" value="">';

  if ($SubmitMode === 'IMPORT' && $plan['ok']) {
    $result = swTrans_Import($mySqlConnObj, $plan, $fdtUserId, $fdtUserName);
    swTrans_PrintResult($result);
  } else {
    swTrans_PrintPlan($plan, $fdtUserName);
  }

  print '</form></div></body></html>';
  exit();

// ------------------------------------------------------------------------------
function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

// SJIS-win のファイルを UTF-8 の行配列にする（無ければ null）
function swTrans_ReadLines($path){
  if (!is_file($path)) { return null; }
  $s = file_get_contents($path);
  if ($s === false) { return null; }
  $s = mb_convert_encoding($s, 'UTF-8', 'SJIS-win');
  $s = str_replace(array("\r\n", "\r"), "\n", $s);
  $lines = explode("\n", $s);
  $out = array();
  foreach ($lines as $ln) { if (trim($ln) !== '') { $out[] = $ln; } }
  return $out;
}

// 1 行を $n 個のフィールドに分割（最後のフィールドにはカンマが含まれてよい）
function swTrans_Fields($line, $n){
  $f = explode(',', $line, $n);
  while (count($f) < $n) { $f[] = ''; }
  return array_map('trim', $f);
}

// ------------------------------------------------------------------------------
//   走査: 取り込む予定の内容を組み立てる（DB は触らない）
// ------------------------------------------------------------------------------
function swTrans_Scan($folder){
  $plan = array('ok' => false, 'message' => '', 'scenarios' => array());
  $idx = swTrans_ReadLines($folder . '/Scenario_index.cgi');
  if ($idx === null) {
    $plan['message'] = $folder . '/Scenario_index.cgi がありません。旧データのフォルダ一式を ' . $folder . '/ に置いてください。';
    return $plan;
  }
  foreach ($idx as $ln) {
    //索引は「旧ID,タイトル,...」で 3 列目以降（旧版のパス等）がある。タイトルは 2 列目だけ
    $f = explode(',', $ln);
    $oldId = trim($f[0]);
    $title = isset($f[1]) ? trim($f[1]) : '';
    if ($oldId === '') { continue; }
    $sc = array('oldId' => $oldId, 'title' => $title, 'characters' => array(), 'scenes' => array(), 'synopsis' => null, 'notes' => array(), 'lineCount' => 0);
    $dir = $folder . '/' . $oldId;
    if (!is_dir($dir)) { $sc['notes'][] = 'フォルダ ' . $oldId . '/ がありません（タイトルだけ登録します）'; $plan['scenarios'][] = $sc; continue; }

    $rows = swTrans_ReadLines($dir . '/character.cgi');
    if ($rows === null) { $sc['notes'][] = 'character.cgi なし'; }
    else foreach ($rows as $r) {
      list($cid, $order, $name, $chara) = swTrans_Fields($r, 4);
      if ($cid === '' || $name === '') { continue; }
      $sc['characters'][] = array('oldId' => $cid, 'order' => $order, 'name' => $name, 'chara' => $chara);
    }

    $rows = swTrans_ReadLines($dir . '/scene.cgi');
    if ($rows === null) { $sc['notes'][] = 'scene.cgi なし'; }
    else foreach ($rows as $r) {
      list($sid, $order, $name, $desc) = swTrans_Fields($r, 4);
      if ($sid === '' || $name === '') { continue; }
      $scene = array('oldId' => $sid, 'order' => $order, 'name' => $name, 'desc' => $desc, 'lines' => array());
      $lrows = swTrans_ReadLines($dir . '/' . $sid . '.cgi');
      if ($lrows === null) { $sc['notes'][] = '場面 ' . $sid . ' の台詞ファイル ' . $sid . '.cgi なし'; }
      else foreach ($lrows as $lr) {
        list($lid, $lorder, $type, $chr, $text) = swTrans_Fields($lr, 5);
        if ($lorder === '') { continue; }
        $scene['lines'][] = array('type' => $type, 'chr' => $chr, 'text' => $text);
      }
      $sc['lineCount'] += count($scene['lines']);
      $sc['scenes'][] = $scene;
    }

    $syn = swTrans_ReadLines($dir . '/synop.cgi');
    if ($syn !== null && count($syn) > 0) { $sc['synopsis'] = implode("\n", $syn); }

    $plan['scenarios'][] = $sc;
  }
  if (count($plan['scenarios']) === 0) { $plan['message'] = 'Scenario_index.cgi にシナリオがありません。'; return $plan; }
  $plan['ok'] = true;
  return $plan;
}

// ------------------------------------------------------------------------------
//   取り込み実行
// ------------------------------------------------------------------------------
function swTrans_Import($db, $plan, $userId, $userName){
  $result = array();
  $prevMode = $db->getAttribute(PDO::ATTR_ERRMODE);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  foreach ($plan['scenarios'] as $sc) {
    $r = array('oldId' => $sc['oldId'], 'title' => $sc['title'], 'newId' => '', 'characters' => 0, 'scenes' => 0, 'lines' => 0, 'synopsis' => false, 'error' => '');
    try {
      $db->beginTransaction();

      $o = new clsSwScenario();
      $o->clsSwScenarioSetUserId($userId);
      $o->clsSwScenarioSetScenarioTitle($sc['title'] !== '' ? $sc['title'] : ('旧シナリオ ' . $sc['oldId']));
      $o->clsSwScenarioSetScenarioSubtitle('');
      $o->clsSwScenarioSetScenarioWriterName($userName);
      $o->clsSwScenarioSetScenarioMemo('旧版から取り込み（旧ID: ' . $sc['oldId'] . '、' . date('Y-m-d H:i') . '）');
      $o->clsSwScenarioSetScenarioCategory(0);
      $newId = $o->clsSwScenarioDbInsert($db);
      $r['newId'] = $newId;

      //登場人物（旧ID → 新ID）
      $charMap = array();
      foreach ($sc['characters'] as $c) {
        $oc = new clsSwCharacter();
        $oc->clsSwCharacterSetScenarioId($newId);
        $oc->clsSwCharacterSetCharacterOrderNo($c['order'] !== '' ? $c['order'] : (count($charMap) + 1) * 100);
        $oc->clsSwCharacterSetCharacterName($c['name']);
        $oc->clsSwCharacterSetCharacterChara($c['chara']);
        $charMap[$c['oldId']] = $oc->clsSwCharacterDbInsert($db);
        $r['characters']++;
      }

      //場面と台詞
      foreach ($sc['scenes'] as $s) {
        $os = new clsSwScene();
        $os->clsSwSceneSetScenarioId($newId);
        $os->clsSwSceneSetSceneOrderNo($s['order'] !== '' ? $s['order'] : ($r['scenes'] + 1) * 100);
        $os->clsSwSceneSetSceneValidCd(0);
        $os->clsSwSceneSetSceneName($s['name']);
        $os->clsSwSceneSetSceneDescription($s['desc']);
        $os->clsSwSceneSetSceneTimeMin(0);
        $os->clsSwSceneSetSceneTimeSec(0);
        $sceneId = $os->clsSwSceneDbInsert($db);
        $r['scenes']++;

        $orderNo = 0;
        foreach ($s['lines'] as $l) {
          //種別変換: 旧 0=台詞 1=ト書 3=歌詞 → 新スタイルID 1=セリフ 2=ト書 3=歌詞
          $charId = -1;
          switch ($l['type']) {
            case '0': $type = 1; if ($l['chr'] !== 'none' && isset($charMap[$l['chr']])) { $charId = $charMap[$l['chr']]; } break;
            case '1': $type = 2; break;
            case '3': $type = 3; break;
            default:  $type = ($l['type'] !== '' && ctype_digit($l['type'])) ? (int)$l['type'] : 2; break;
          }
          $text = rtrim($l['text']);
          while (substr($text, -4) === '<br>') { $text = rtrim(substr($text, 0, -4)); }
          $orderNo += 100;
          $ol = new clsSwScenarioLines();
          $ol->clsSwScenarioLinesSetScenarioId($newId);
          $ol->clsSwScenarioLinesSetSceneId($sceneId);
          $ol->clsSwScenarioLinesSetScenarioLinesOrderNo($orderNo);
          $ol->clsSwScenarioLinesSetScenarioType($type);
          $ol->clsSwScenarioLinesSetCharacterId($charId);
          $ol->clsSwScenarioLinesSetScenarioLines($text);
          $ol->clsSwScenarioLinesDbInsert($db);
          $r['lines']++;
        }
      }

      //シノプシス（改行は <br> で保存。編集画面と同じ）
      if ($sc['synopsis'] !== null) {
        $oy = new clsSwSynopsis();
        $oy->clsSwSynopsisSetScenarioId($newId);
        $oy->clsSwSynopsisSetSynopsis(str_replace("\n", '<br>', $sc['synopsis']));
        $oy->clsSwSynopsisDbInsert($db);
        $r['synopsis'] = true;
      }

      $db->commit();
    } catch (Exception $e) {
      if ($db->inTransaction()) { $db->rollBack(); }
      $r['error'] = $e->getMessage();
      $r['newId'] = '';
    }
    $result[] = $r;
  }
  $db->setAttribute(PDO::ATTR_ERRMODE, $prevMode);
  return $result;
}

// ------------------------------------------------------------------------------
//   表示
// ------------------------------------------------------------------------------
function swTrans_PrintPlan($plan, $userName){
  print '<h4>旧データの取り込み</h4>';
  if (!$plan['ok']) {
    print '<div class="alert alert-warning">' . h($plan['message']) . '</div>';
    print '<p class="text-muted" style="font-size:13px;">置き方: ScenarioFolder/Scenario_index.cgi と、旧シナリオIDごとのフォルダ（character.cgi / scene.cgi / 場面ID.cgi / synop.cgi）。文字コードは旧版のまま（Shift_JIS）で構いません。</p>';
    return;
  }
  print '<div class="alert alert-info">ScenarioFolder/ に次の内容が見つかりました。「取り込む」を押すと、ログイン中のユーザー <b>' . h($userName) . '</b> のシナリオとして新しい ID で登録します。元のファイルは変更しません。すでに取り込み済みでも重複して登録されるので、二度押ししないでください。</div>';
  print '<table class="table table-sm"><thead><tr><th>旧ID</th><th>タイトル</th><th class="text-end">登場人物</th><th class="text-end">場面</th><th class="text-end">台詞</th><th>シノプシス</th><th>備考</th></tr></thead><tbody>';
  foreach ($plan['scenarios'] as $sc) {
    print '<tr><td>' . h($sc['oldId']) . '</td><td>' . h($sc['title']) . '</td><td class="text-end">' . count($sc['characters']) . '</td><td class="text-end">' . count($sc['scenes']) . '</td><td class="text-end">' . $sc['lineCount'] . '</td><td>' . ($sc['synopsis'] !== null ? 'あり' : '') . '</td><td style="font-size:12px;">' . h(implode(' / ', $sc['notes'])) . '</td></tr>';
  }
  print '</tbody></table>';
  print '<button type="button" class="btn btn-success" onclick="if(confirm(\'取り込みを実行します。よろしいですか？\')){document.getElementById(\'SubmitMode\').value=\'IMPORT\';document.frmSwTrans.submit();}">取り込む</button> ';
  print '<button type="button" class="btn btn-outline-secondary" onclick="AjaxFunc_SubmitNoMsg(document.frmSwTrans,\'./swScenarioSelect.php\');">シナリオ選択へ戻る</button>';
}

function swTrans_PrintResult($result){
  print '<h4>取り込み結果</h4>';
  $ng = 0;
  print '<table class="table table-sm"><thead><tr><th>旧ID</th><th>タイトル</th><th>新ID</th><th class="text-end">登場人物</th><th class="text-end">場面</th><th class="text-end">台詞</th><th>シノプシス</th><th>結果</th></tr></thead><tbody>';
  foreach ($result as $r) {
    if ($r['error'] !== '') { $ng++; }
    print '<tr><td>' . h($r['oldId']) . '</td><td>' . h($r['title']) . '</td><td>' . h($r['newId']) . '</td><td class="text-end">' . $r['characters'] . '</td><td class="text-end">' . $r['scenes'] . '</td><td class="text-end">' . $r['lines'] . '</td><td>' . ($r['synopsis'] ? 'あり' : '') . '</td><td>' . ($r['error'] === '' ? '<span class="text-success">OK</span>' : '<span class="text-danger">失敗（取り消しました）: ' . h($r['error']) . '</span>') . '</td></tr>';
  }
  print '</tbody></table>';
  print '<div class="alert ' . ($ng ? 'alert-danger' : 'alert-success') . '">' . ($ng ? $ng . ' 件が失敗しました。' : '取り込みが完了しました。') . ' 取り込んだシナリオはシナリオ選択に表示されます。二重登録を防ぐため、取り込み後は ScenarioFolder/ の中身を別の場所へ移してください。</div>';
  print '<button type="button" class="btn btn-primary" onclick="AjaxFunc_SubmitNoMsg(document.frmSwTrans,\'./swScenarioSelect.php\');">シナリオ選択へ</button>';
}
// -----------------------------------------------------------
?>
