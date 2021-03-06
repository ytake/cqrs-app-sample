# CQRS Application Sample

PHPを使って理解しやすいようなサンプルにしています。  
実際に実践する場合は無理にPHPだけではやらずに適材適所な言語などを組み合わせてください。

## Required 

PHP(Laravel), Apache Kafka(& zookeeper), MySQL、Elasticsearch

### Apache Kafka

recommended [confluent platform](https://www.confluent.jp/)

## 要件例

いくつかキーワードを投稿して、そのキーワードを見れるのはもちろんなんですが、  
ワードクラウドみたいなものを実現したいんですよね！  

キーワードはキーワードそのものと識別可能なユーザー情報、ここでは例としてuserIDだけにしましょう。  
ワードクラウドライクなものはどう実現したらよいでしょう？  
キーワードとはまた違う概念になりそう（コール数の概念が加わります）で、Elasticsearchを使えば実現できそうです。

## 処理の流れ

### Command + Event Sourcing

 - PHP（フォーム） 
 - MySQL(スナップショット/実際には他のものを利用してください)
 - Apache Kafka
 
### 読み込みモデル更新処理

 - ReadModel Handler(Laravel CLI)
 - Elasticsearch

supervisorやsystemdで動かすと良いでしょう。

### Query

 - Elasticsearch
 - PHP

## なぜLaravelのQueueを使わないのですか？

この処理だけではおそらく実現できますが、  
現実問題として同じQueueの中身を他のプロセスが処理するケースもあるでしょう。  
例えばブログを投稿した、をトリガーにキーワードの内容をpublishしたとします。

Elasticsearchにinsertする以外にRDBMSに正規化して持たせたい場合にどうすればいいでしょうか？  
同じプロセスで処理する場合は2フェーズコミットになりそうです。  
この場合、それぞれを担当するプロセスに分割した方は良さそうです。  
必要とするのはラウンドロビンではない方法が望ましいです。  

これはフレームワークの範囲を超えているので、専用のミドルウェアを使った方が良いでしょう。

## Run

### 1. Setup

アプリケーションを動かす前に実行してください

```bash
$ docker-compose up -d
# 各ミドルウェアはコンテナですが起動に時間がかかります。
# しばらくお待ちください。
# これらのミドルウェアを使う場合、商用ではコンテナではなく物理的HDDで動かしましょう。
$ docker-compose exec php composer install --prefer-dist --no-interaction && composer app-setup
$ docker-compose exec php /var/www/html/artisan migrate
```

### 2. Elasticsearch

tokenizerなどを設定します。

```bash
$ curl -X PUT 'http://localhost:9200/words' -H 'Content-Type: application/json' -d @dataset/mapping.json
$ curl -X POST 'http://localhost:9200/_bulk?pretty' -H 'Content-Type: application/json' --data-binary @dataset/words.json
```

### 3. Topic Subscribe

```bash
$ docker-compose exec php /var/www/html/artisan sample:subscribe_es
$ docker-compose exec php /var/www/html/artisan sample:subscribe_mysql
```

