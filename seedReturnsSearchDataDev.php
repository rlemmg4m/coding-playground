<?php

/**
 *  Use this small script to populate local elastic-search environment with document dats
 *  ensure you've used composer install / update to gain access to the elastic php library and faker
 */
define('APP_BASE_DIR', realpath(__DIR__));
require_once APP_BASE_DIR . '/vendor/autoload.php';

const LOCAL_ELASTIC = 'http://localhost:9200';
const INSERT_SIZE = 1000;
const INDEX_NAME = 'returns_index';
const INDEX_TYPE = 'returns'; // perhaps chose a better name?

// Set basic elastic client, change port if you've got it running elsewhere
$elastic_client = Elasticsearch\ClientBuilder::create()->setHosts([LOCAL_ELASTIC])->build();
$faker = Faker\Factory::create('en_GB');


/**
 * Create an index and populate it with fake data
 * TODO - ensure it matches the format to be decided
 */
for ($i = 1; $i < INSERT_SIZE + 1; $i++) {
    $params = [
        'index' => INDEX_NAME,
        'type' => INDEX_TYPE,
        'id' => $i,
        'body' => [
            'returns_id' => $faker->randomNumber(1),
            'tracking_reference' => $faker->uuid,
            'order_number' => $faker->randomLetter . $faker->randomLetter . '_' . $faker->randomNumber(5)
        ]
    ];

    try {
        $elastic_client->index($params);
    } catch (Exception $exception) {
        die('Error encountered seeding fake data into elastic-search ['
            . LOCAL_ELASTIC . '] : ' . $exception->getMessage());
    }
}

print("End of seeding script, let's hope it worked \n ");
