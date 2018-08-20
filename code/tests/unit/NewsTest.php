<?php

use common\models\News;

class NewsTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testGetFirstImageUrl()
    {
        $news = News::findOne(['id' => 10]);
        $this->assertEquals('/images/56c563b0b01d9.jpg', $news->getFirstImageUrl());

    }
}