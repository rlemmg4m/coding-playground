<?php

namespace Gear4music\ReturnsSearch\Data\Repository\ElasticSearch;

use Gear4music\ReturnsSearch\Data\Repository\ElasticSearch;
use Elasticsearch\ClientBuilder;

class Returns extends ElasticSearch
{

    const ELASTIC_INDEX = 'returns_index';
    const ELASTIC_TYPE = 'returns';

    /**
     * @var \Elasticsearch\Client
     */
    private $obj_elastic_client;
    /**
     * @var array
     */
    private $arr_elastic_params;

    /**
     * @var array
     */
    private $arr_elastic_response;

    /**
     * Returns constructor.
     */
    public function __construct()
    {
        $this->obj_elastic_client = ClientBuilder::create()->build();
    }

    /**
     * @param $str_search_field
     * @param $str_search_identifier
     * @return array
     */
    public function search($str_search_field, $str_search_identifier)
    {
        $this->arr_elastic_params = [
            'index' => self::ELASTIC_INDEX,
            'type' => self::ELASTIC_TYPE,
            'body' => [
                'query' => [
                    'match' => [
                        $str_search_field => $str_search_identifier
                    ]
                ]
            ]
        ];

        $this->arr_elastic_response = $this->obj_elastic_client->search($this->arr_elastic_params);

        return $this->arr_elastic_response;
    }
}
