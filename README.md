# Windowsで空色えきぞちっくHP作成！

## 構築環境

OS：Windows10

ターミナル：cmder

下記URLを参考にインストール

http://nelog.jp/cmder

ユーザーフォルダ名が日本語だと詰むからその時はこれ
※なんかしらに影響あるかも

http://nattomix.blog82.fc2.com/blog-entry-161.html


## 環境構築手順

### １．PHPのインストール

このURL参考

http://www.phpbook.jp/install/

でも、PHPのversionは5.6.XX系にすること。

タイムゾーンの設定もしておく。

http://qiita.com/maximum80/items/d8c841ccdaf6f8106b3f

### ２．Composerのインストール

このURL参考

http://qiita.com/mikoski01/items/266469535e860312145d

コマンド叩いてでもできるけど、インストーラーでやるとインストールが完了した時点ですべて整う。

### ３．projectをクローンする

下記コマンドをターミナルで実行する。

```
$ git clone https://github.com/uucyan/sorairo-exotic.git
$ composer install
```

### ４．MySQLの設定

MySQLのインストールは下記参考

http://www.dbonline.jp/mysqlinstall/

pdo_mysqlを使えるようにphp.iniを編集する。

下記のコメントアウトを外す（参考： http://www.hiskip.com/pg-notes/lang/php/phpdb/327.html ）

```
;extension=php_pdo_mysql.dll
```

マイグレーションとか実装してないから手動でクエリを流します。
あと、MySQLの設定ファイルも編集する必要あり。

テーブル作成、マスターデータ追加、設定ファイル内容はWikiを参照（ https://github.com/uucyan/sorairo-exotic/wiki/MySQL%E3%81%A7%E3%81%AE%E5%88%9D%E6%9C%9F%E3%83%87%E3%83%BC%E3%82%BF%E6%8A%95%E5%85%A5 ）

### ５．ローカル環境でアクセス
PHPのビルトインウェブサーバをターミナルから起動

```
$ php -S 127.0.0.1:8080 -t web
```

起動したら下記でアクセス、ホームページが表示されれば成功。

```
http://127.0.0.1:8080
```

### git関係

もろもろ設定

http://qiita.com/wnoguchi/items/f7358a227dfe2640cce3#git-diff-%E3%81%AB%E8%89%B2%E4%BB%98%E3%81%91%E3%81%97%E3%81%9F%E3%81%84

http://qiita.com/unsoluble_sugar/items/ce14e9ce20aa5ba34fe5
