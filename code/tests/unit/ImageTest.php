<?php

use common\models\Image;

class ImageTest extends \Codeception\TestCase\Test
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
    public function testGetUrlPath()
    {
        $url = '/images-cache//56c4471eb6c35-mini100.jpg';
        $this->assertEquals('/home/user/public_html/sportgid/frontend/web//images-cache//56c4471eb6c35-mini100.jpg',
            Image::getUrlPath($url), 'Верно');
    }

    public function testGetThumbnail(){
        $url = '/images/2016/02/56c6c70e0efc0.jpg';
        $this->assertEquals('/images-cache/56c6c70e0efc0-mini100.jpg', Image::getThumbnail($url));
        $url = '/images/56c44531eb6e6.jpg';
        $this->assertEquals('/images-cache/56c44531eb6e6-mini100.jpg', Image::getThumbnail($url));
    }

}