<?php

use PHPUnit\Framework\TestCase;


final class ReturnsTest extends TestCase
{

    public function testCanCreateElasticReturn()
    {
        $obj_return = new \Gear4music\ReturnsSearch\Data\Repository\ElasticSearch\Returns();
        $this->assertInstanceOf(\Gear4music\ReturnsSearch\Data\Repository\ElasticSearch\Returns::class,$obj_return);
    }

    public function testReturnDataArray()
    {
        $obj_return_data = (new \Gear4music\ReturnsSearch\Data\Repository\ElasticSearch\Returns())
            ->search("returns_id","5")->getData();
        $this->assertInternalType("array",$obj_return_data);
    }
}
