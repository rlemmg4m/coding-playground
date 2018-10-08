<?php
/**
 * Created by PhpStorm.
 * User: robert.lemm
 * Date: 08/10/2018
 * Time: 12:11
 */

namespace Gear4music\ReturnsSearch\Data\Repository\Noop;

use Gear4music\ReturnsSearch\Data\Repository\ElasticSearch;

class Returns extends ElasticSearch
{
    public function __construct()
    {
        // Does nothing
    }

    public function search($str_search_field, $str_search_identifier)
    {
        if ("return_id" === $str_search_field && "12345" === $str_search_identifier) {
            return json_decode('{"took":1,"timed_out":false,"_shards":{"total":5,"successful":5,"skipped":0,"failed":0},"hits":{"total":5047,"max_score":0.70912355,"hits":[{"_index":"returns_index","_type":"return","_id":"12345","_score":1.00,"_source":{"return_id":"12345","order_number":"ABC1234","enquiry_id":"enq_12345"}}]}}');
        }
    }

    public function getData()
    {
        return ['_source' => 'NOOP - DATA'];
    }

    public function getMetaData()
    {
        return ['_source' => 'NOOP - DATA'];
    }
}
