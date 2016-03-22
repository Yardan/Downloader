<?php
namespace tests\unit;

use Yardan\Downloader\Exception\TypeException;
use Yardan\Downloader\LinkCorrecter;

class LinkCorrecterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Colibrating
     */
    public function testStringColibration()
    {
        $this->assertEquals('test', 'test');
    }

    /**
     * For colibration
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Right Message
     */
    public function testExceptionHasRightMessage()
    {
        throw new \InvalidArgumentException('Right Message', 10);
    }

    /**
     * Test correct url with http
     * @throws TypeException
     */
    public function testHttpString()
    {
        $link = 'http://test.com';
        $expectedResult = 'http://test.com';
        $corrector = new LinkCorrecter();

        $corrector->correctLink($link);
        $this->assertEquals($expectedResult, $corrector->correctLink($link));
    }

    /**
     * Test correct url without http
     * @throws TypeException
     */
    public function testDomainString()
    {
        $link = 'test.com';
        $expectedResult = 'http://test.com';
        $corrector = new LinkCorrecter();

        $corrector->correctLink($link);
        $this->assertEquals($expectedResult, $corrector->correctLink($link));
    }

    /**
     * Test wrong url correcting
     * @throws TypeException
     */
    public function testWrongStringCorrecter()
    {
        $link = 'hppt://test.com';
        $expectedResult = 'http://test.com';
        $corrector = new LinkCorrecter();

        $corrector->correctLink($link);
        $this->assertEquals($expectedResult, $corrector->correctLink($link));
    }

    /**
     * Test exception if url is not string
     * @expectedException Yardan\Downloader\Exception\TypeException
     * @expectedExceptionMessage $link must be string
     */
    public function testException()
    {
        $link = 1;
        $expectedResult = 'http://test.com';
        $corrector = new LinkCorrecter();
        $this->assertEquals($expectedResult, $corrector->correctLink($link));
    }

}