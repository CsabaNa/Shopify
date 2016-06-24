<?php

        class ShopifyTest extends PHPUnit_Framework_TestCase
        {
            public function testShopifyConnect()
            {
                $testObj = new Shopify\Shopify();
                $item    = $testObj->connect();

                $this->assertInternalType('array',$item);

                $this->assertArrayHasKey('', $item);
                $this->assertArrayHasKey('', $item);
                $this->assertArrayHasKey('', $item);
            }

            public function testUploadItem()
            {
                $testObj 	= new Shopify\Shopify();
                $item 		= $testObj->getItem();

                $this->setExpectedException('Exception');
            }

            public function testUploadWrongItem()
            {
                $testObj    = new Shopify\Shopify();

                $this->setExpectedException('Exception');
            }

            public function testGetItems()
            {
                $testObj    = new Shopify\Shopify();

                $this->setExpectedException('Exception');
            }
        }

?>