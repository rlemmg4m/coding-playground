<?php

namespace Gear4music\ReturnsSearch\Data\Repository\ElasticSearch;

use Elasticsearch\Common\Exceptions\NoNodesAvailableException;
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
        //TODO remove allowBadJSONSerialization() when swapping back to version 6.0
        $this->obj_elastic_client = ClientBuilder::create()->allowBadJSONSerialization()->setHosts(['elasticsearch'])->build();
    }

    /**
     * @param $str_search_field
     * @param $str_search_identifier
     * @param int $int_search_size
     * @return $this
     * @throws \Gear4music\JAPI\Exceptions\ErrorResponse
     */
    public function search($str_search_field, $str_search_identifier, $int_search_size = 500)
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
            ],
            'size' => $int_search_size
        ];

        try {
            $this->arr_elastic_response = $this->obj_elastic_client->search($this->arr_elastic_params);
            return $this;
        } catch (\Exception $exception) {
            throw new \Gear4music\JAPI\Exceptions\ErrorResponse('Exception raised searching elastic : '
                . $exception->getMessage(), 404);
        }
    }

    public function getData()
    {
        return $this->arr_elastic_response['hits']['hits'];
    }

    public function getMetaData()
    {
        return $this->arr_elastic_response;
    }
}
