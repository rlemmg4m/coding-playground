<?php

/**
 *  Use this small script to populate local elastic-search environment with document dats
 *  ensure you've used composer install / update to gain access to the elastic php library and faker
 */
define('APP_BASE_DIR', realpath(__DIR__));
require_once APP_BASE_DIR . '/vendor/autoload.php';

const LOCAL_ELASTIC = 'http://localhost:9200';


// Set basic elastic client, change port if you've got it running elsewhere
$elastic_client = Elasticsearch\ClientBuilder::create()->setHosts([LOCAL_ELASTIC])->build();


$params = [
    'index' => 'returns_index',
    'type' => 'returns',
    'body' => [
        'query' => [
            'match' => [
                'returns_id' => '2'
            ]
        ]
    ],
    'size' => 1
];

$response = $elastic_client->search($params);
echo "<pre>";
print_r(json_encode($response));

print("End of seeding script, let's hope it worked \n ");
