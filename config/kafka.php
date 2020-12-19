<?php
declare(strict_types=1);
use App\Console\Commands;
return [
    'brokers' => env('KAFKA_BROKERS'),
    'topics' => [
        'entry' => [
            'created' => env('KAFKA_ENTRY_TOPIC'),
            'client_id' => 'eigei3phai6teeThuaL3',
            'group_id_es' => Commands\KafkaSubscribeElasticsearchCommand::class,
            'group_id_db' => Commands\KafkaSubscribeMySqlCommand::class,
        ]
    ]
];
