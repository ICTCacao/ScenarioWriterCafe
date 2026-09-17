# ScenarioWriterCafe

舞台・映像の脚本を Web ブラウザで書くための、ひとり用の脚本エディタです。
PHP と SQLite だけで動くので、レンタルサーバや手元の PC にフォルダを置くだけで始められます。

## 特長

- **場面・登場人物・台詞** を分けて書き、並び替えや複写ができる
- 台詞をクリックしてその場で直す **インライン編集（自動保存）**
- **劇団員プレビュー** … 鍵付き URL を渡すだけで、ログインなしにスマホで読める（縦書き / 横書き切替）
- **ダウンロード** … テキスト、Word（A4 縦書き / 横書き）、XML
- 台詞の色・字下げ・「」の付け方などを **スタイル設定** で自分好みに
- **SQLite（標準）** または **MySQL / MariaDB** を選べる。DB サーバ不要で動く
- 旧 CGI 版のデータ取り込みツール付き

## 必要なもの

- PHP 7.4 以上（8.x 推奨）。PDO の `sqlite` または `mysql` ドライバ（通常は同梱）
- Apache なら `.htaccess` がそのまま効きます。nginx 等では `sw_config/` への直接アクセスを拒否する設定を別途入れてください

## インストール

1. このリポジトリの内容（または [Releases](../../releases) の zip）を Web 公開ディレクトリに置く。サブディレクトリでも可
2. `sw_config/` `tmp/` `img/thumb/` に書込権限を付ける（レンタルサーバの既定で足りることが多い）
3. ブラウザで `index.php` を開く → 初期設定画面
4. 「データベース種別」は標準で **SQLite** が選ばれています。メールアドレスとパスワードを入れて「インストール」
5. ログイン画面に移るので、登録した情報でログイン

設定後は `swSetup.php` を削除するか、アクセス制限してください。

手元で試すだけなら PHP の組み込みサーバでも動きます。

```bash
php -S 127.0.0.1:8080
# → http://127.0.0.1:8080/index.php
```

## 劇団員プレビュー

「シナリオ情報」画面の「劇団員プレビュー」で **公開する** を押すと、`swPreview.php?k=…` の URL が発行されます。
URL を知っている人だけが閲覧でき（編集不可）、**停止する** で無効になります。スマホ向けの画面で、縦書き / 横書きと文字サイズを切り替えられます。

## 旧 CGI 版からの移行

旧版のデータ一式（`Scenario_index.cgi` とシナリオごとのフォルダ）を `ScenarioFolder/` に置き、ログイン後に `swScenarioTrans.php` を開いて「取り込む」を押します。内容を確認してから実行され、SQLite / MySQL どちらでも動きます。

## バックアップ

SQLite の場合は `sw_config/swdata.sqlite`（あれば `-wal` `-shm` も）をコピーするだけです。

## ディレクトリ

| 場所 | 内容 |
|---|---|
| `sw_config/` | 設定とスキーマ。SQLite の DB ファイルもここ。Web からは `.htaccess` で拒否 |
| `include/` | 共通処理（DB 接続 `swDb.php`、プレビュー `swPreview.php` など） |
| `class/` | テーブルごとのデータクラス |
| `ajax/` | 画面から呼ばれる処理 |
| `Scenario_Template/` | Word 出力のテンプレート |

## ライセンス

MIT License。詳細は [LICENSE](LICENSE) を参照してください。

同梱している第三者ライブラリ（`js/scw.js` に束ねています）: jQuery、jQuery UI、Masonry、Bootstrap、bootbox、Autosize（MIT）、bootstrap-fileinput（BSD-3-Clause）。各ライブラリの著作権表示は `js/scw.js` 内に残しています。
