<?php
/**
 *  Use this small script to populate local elastic-search environment with document dats
 *  ensure you've used composer install / update to gain access to the elastic php library and faker
 */
define('APP_BASE_DIR', realpath(__DIR__));
require_once APP_BASE_DIR . '/vendor/autoload.php';

const LOCAL_ELASTIC = 'http://localhost:9200';
const INSERT_SIZE = 10000;

// Set basic elastic client, change port if you've got it running elsewhere
$elastic_client = Elasticsearch\ClientBuilder::create()->setHosts([LOCAL_ELASTIC])->build();
$faker = Faker\Factory::create('en_GB');

$arr_index_setup_tracking = [
    'index' => 'search_index_tracking',
    'body' => [
        'settings' => [
            'number_of_shards' => 5, // default
            'number_of_replicas' => 2
        ],
        'mappings' => [
            'tracking_reference' => [
                '_source' =>
                    [
                        'enabled' => true
                    ],
                'properties' => [
                    'tracking_reference' => [
                        'type' => 'keyword',
                    ]
                ]
            ]
        ]
    ]
];
$arr_index_setup_order = [
    'index' => 'search_index_order',
    'body' => [
        'settings' => [
            'number_of_shards' => 5, // default
            'number_of_replicas' => 2
        ],
        'mappings' => [
            'order_number' => [
                '_source' =>
                    [
                        'enabled' => true
                    ],
                'properties' => [
                    'order_number' => [
                        'type' => 'keyword',
                    ]
                ]
            ]
        ]
    ]
];
$arr_index_setup_enquiry = [
    'index' => 'search_index_enquiry',
    'body' => [
        'settings' => [
            'number_of_shards' => 5, // default
            'number_of_replicas' => 2
        ],
        'mappings' => [
            'enquiry_id' => [
                '_source' =>
                    [
                        'enabled' => true
                    ],
                'properties' => [
                    'enquiry-id' => [
                        'type' => 'keyword',
                    ]
                ]
            ]
        ]
    ]
];

/**
 * Fire indices into elastic host
 */
try {
    $elastic_client->indices()->create($arr_index_setup_tracking);
    echo "\n Tracking_reference Index Created with mapping \n ";
    $elastic_client->indices()->create($arr_index_setup_order);
    echo "\n Order_number Index Created with mapping \n ";
    $elastic_client->indices()->create($arr_index_setup_enquiry);
    echo "\n Enquiry_id Index Created with mapping \n ";

    echo "\n Indices Created \n ";

} catch (Exception $exception) {
    die("Exception raised : " . $exception->getMessage());
}
echo "\n Populating indices \n ";

// Loop and populate data in each
for ($i = 1; $i < INSERT_SIZE + 1; $i++) {
    $params_tracking = [
        'index' => 'search_index_tracking',
        'type' => 'tracking_reference',
        'id' => $i,
        'body' => [
            'tracking_reference' => $faker->uuid,
        ]
    ];
    $params_order = [
        'index' => 'search_index_order',
        'type' => 'order_number',
        'id' => $i,
        'body' => [
            'order_number' => $faker->randomElement(['W', 'M']) . $faker->randomNumber(6),
        ]
    ];
    $params_enquiry = [
        'index' => 'search_index_enquiry',
        'type' => 'enquiry_id',
        'id' => $i,
        'body' => [
            'enquiry_id' => 'E' . $faker->randomNumber(6),
        ]
    ];

    try {
        $elastic_client->index($params_tracking);
        $elastic_client->index($params_order);
        $elastic_client->index($params_enquiry);
    }catch (Exception $exception)
    {
        die("Exception raised : " . $exception->getMessage());
    }
}
echo "\n Populating indices \n ";
