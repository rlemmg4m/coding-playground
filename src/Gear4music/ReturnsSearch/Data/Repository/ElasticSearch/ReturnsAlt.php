<?php

namespace Gear4music\ReturnsSearch\Data\Repository\ElasticSearch;

use Elasticsearch\Common\Exceptions\NoNodesAvailableException;
use Gear4music\ReturnsSearch\Data\Repository\ElasticSearch;
use Elasticsearch\ClientBuilder;

class ReturnsAlt extends ElasticSearch
{

    const ELASTIC_INDICES = 'search_index_order,search_index_tracking,search_index_enquiry';
    const ELASTIC_TYPES = 'order_number,tracking_reference,enquiry_id';

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
        //TODO remove allowBadJSONSerialization() when upgrading back to version 6.0
        $this->obj_elastic_client = ClientBuilder::create()
            ->allowBadJSONSerialization()
            ->setHosts(['elasticsearch'])
            ->build();
    }

    /**
     * @param $str_search_field
     * @param $str_search_identifier
     * @param int $int_search_size
     * @return $this
     * @throws \Gear4music\JAPI\Exceptions\ErrorResponse
     */
    public function search($str_search_identifier, $int_search_size = 1000)
    {
        $this->arr_elastic_params = [
            'index' => self::ELASTIC_INDICES,
            'type' => self::ELASTIC_TYPES,
            'body' => [
                'query' => [
                    'query_string' => [
                        'query' => '*'.$str_search_identifier.'*'
                    ]
                ]
            ],
            'size' => $int_search_size,
        ];

        try {
            $this->arr_elastic_response = $this->obj_elastic_client->search($this->arr_elastic_params);
            return $this;
        } catch (\Exception $exception) {
            throw new \Gear4music\JAPI\Exceptions\ErrorResponse('Exception raised searching elastic : '
                . $exception->getMessage()   );
        }
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        $arr_result_data = [];
        foreach($this->arr_elastic_response['hits']['hits'] as $results)
        {
            $arr_result_data[] = ['return_id' => $results['_id']
                , 'type' => $results['_type'] , 'match' => $results['_source']];
        }
        return $arr_result_data;
    }

    /**
     * @return array|mixed
     */
    public function getMetaData()
    {
        return $this->arr_elastic_response;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->arr_elastic_response['hits']['total'];
    }
}
