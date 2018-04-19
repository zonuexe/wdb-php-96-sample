PHP大規模開発入門 第17回
========================

## サンプルコードについて

今回のサンプルコードには以下の内容が含まれます。

 * PHP対話実行環境(PsySH)
 * Whoopsを使ったエラー表示
 * Whoopsを応用したらエラーログ記録
 * 記録されたエラーログを表示する機能
 * テンプレートエンジンを利用しない脆弱なコード例

## インストール

 1. https://getcomposer.org/download/ に従ってComposerをダウンロード
 2. `php composer.phar install` または `composer install`
 3. `php ./setup` を実行する (または `.env` ファイルを手動で作成)

## 実行方法

### PHP対話実行環境(PsySH)

シェルで以下のようなコマンドを実行すると起動できます。

```
$ php shell.php
```

### Web

```sh
$ php -S localhost:3939 -t public/
```

ブラウザで http://localhost:3939/ を開くと動作検証ができます。
