# cqrs-app-sample

PHPを使って理解しやすいようなサンプルにしています。  
実際に実践する場合は無理にPHPだけではやらずに適材適所な言語などを組み合わせてください。

## Required 

PHP(Laravel), Apache Kafka, Apache Cassandra、Elasticsearch

### Apache Kafka

recommended [confluent platform](https://www.confluent.jp/)

## 要件例

ブログを投稿して、そのブログを見れるのはもちろんなんですが、  
キーワードを取り出してワードクラウドみたいなものを実現したいんですよね！  

ブログは本文と識別可能なユーザー情報、ここでは例としてuserIDだけにしましょう。  
ワードクラウドライクなものはどう実現したらよいでしょう？  
Elasticsearchを使えば実現できそうですが、ブログとはまた違う概念になりそうです。  

## 処理の流れ

### Command + Event Sourcing

 - PHP（フォーム） 
 - Apache Cassandra(スナップショット)
 - Apache Kafka
 
### 読み込みモデル更新処理

 - ReadModel Handler(Laravel CLI)
 - Elasticsearch

supervisorやsystemdで動かすと良いでしょう。

### Query

 - Elasticsearch
 - PHP
