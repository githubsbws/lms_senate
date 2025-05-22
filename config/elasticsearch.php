<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Elasticsearch Host
    |--------------------------------------------------------------------------
    |
    | Define the host where your Elasticsearch instance is running.
    | This could be an IP address or a domain name. Make sure the host
    | is reachable and the port is correct for your setup.
    |
    */

    'host' => [
        env('ELASTICSEARCH_HOST', 'http://localhost:9200'),
    ],
    'port' => env('ELASTICSEARCH_PORT', 9200),
    'scheme' => env('ELASTICSEARCH_SCHEME', 'http'),
    'user' => env('ELASTICSEARCH_USER', 'elastic'),
    'pass' => env('ELASTICSEARCH_PASS', ''),
    'ssl_verification' => env('ELASTICSEARCH_SSL_VERIFICATION', false),
    /*
    |--------------------------------------------------------------------------
    | Elasticsearch Index Settings
    |--------------------------------------------------------------------------
    |
    | Define the settings for the Elasticsearch indexes. The settings allow
    | you to configure various Elasticsearch options like analyzers, mappings,
    | etc.
    |
    */

    'index_settings' => [
        'number_of_shards' => 1,
        'number_of_replicas' => 0,
    ],

    /*
    |--------------------------------------------------------------------------
    | Elasticsearch SCOUT Configuration
    |--------------------------------------------------------------------------
    |
    | These settings configure how Scout should communicate with Elasticsearch.
    | You can adjust the settings here for your needs, like batch size, etc.
    |
    */

    'batch_size' => env('SCOUT_BATCH_SIZE', 100),

    /*
    |--------------------------------------------------------------------------
    | Elasticsearch Connection Timeout
    |--------------------------------------------------------------------------
    |
    | Timeout (in seconds) for connecting to the Elasticsearch server.
    |
    */

    'timeout' => env('ELASTICSEARCH_TIMEOUT', 10),
];
