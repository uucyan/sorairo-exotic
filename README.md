# Windowsで空色えきぞちっくHP作成！

## 大前提

OS：Windows10
ターミナル：cmder
下記URLを参考にインストール
http://nelog.jp/cmder
ユーザーフォルダ名が日本語だと詰むからその時はこれ
※なんかしらに影響あるかも
http://nattomix.blog82.fc2.com/blog-entry-161.html

大前提とか言いつつ、別にWin10じゃなくても大丈夫だし、ターミナルなんて自由。
おれはこの環境でやったんじゃああああ

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

$ git clone http://qiita.com/mikoski01/items/266469535e860312145d
$ composer install

上の２つ叩くだけで終わると思う。
後はPHPのビルトインウェブサーバを起動したらいけるはず！

$ php -S 127.0.0.1:8080 -t web
http://127.0.0.1:8080

### ４．MySQLの設定
後で書く
これは手順３．の前にくるかもね

### git関係

もろもろ設定
http://qiita.com/wnoguchi/items/f7358a227dfe2640cce3#git-diff-%E3%81%AB%E8%89%B2%E4%BB%98%E3%81%91%E3%81%97%E3%81%9F%E3%81%84
http://qiita.com/unsoluble_sugar/items/ce14e9ce20aa5ba34fe5
