<?php

namespace _PhpScoper26e51eeacccf;

use _PhpScoper26e51eeacccf\RingCentral\Psr7\ServerRequest;
class ServerRequestTest extends \_PhpScoper26e51eeacccf\PHPUnit_Framework_TestCase
{
    private $request;
    public function setUp()
    {
        $this->request = new \_PhpScoper26e51eeacccf\RingCentral\Psr7\ServerRequest('GET', 'http://localhost');
    }
    public function testGetNoAttributes()
    {
        $this->assertEquals(array(), $this->request->getAttributes());
    }
    public function testWithAttribute()
    {
        $request = $this->request->withAttribute('hello', 'world');
        $this->assertNotSame($request, $this->request);
        $this->assertEquals(array('hello' => 'world'), $request->getAttributes());
    }
    public function testGetAttribute()
    {
        $request = $this->request->withAttribute('hello', 'world');
        $this->assertNotSame($request, $this->request);
        $this->assertEquals('world', $request->getAttribute('hello'));
    }
    public function testGetDefaultAttribute()
    {
        $request = $this->request->withAttribute('hello', 'world');
        $this->assertNotSame($request, $this->request);
        $this->assertEquals(null, $request->getAttribute('hi', null));
    }
    public function testWithoutAttribute()
    {
        $request = $this->request->withAttribute('hello', 'world');
        $request = $request->withAttribute('test', 'nice');
        $request = $request->withoutAttribute('hello');
        $this->assertNotSame($request, $this->request);
        $this->assertEquals(array('test' => 'nice'), $request->getAttributes());
    }
    public function testWithCookieParams()
    {
        $request = $this->request->withCookieParams(array('test' => 'world'));
        $this->assertNotSame($request, $this->request);
        $this->assertEquals(array('test' => 'world'), $request->getCookieParams());
    }
    public function testWithQueryParams()
    {
        $request = $this->request->withQueryParams(array('test' => 'world'));
        $this->assertNotSame($request, $this->request);
        $this->assertEquals(array('test' => 'world'), $request->getQueryParams());
    }
    public function testWithUploadedFiles()
    {
        $request = $this->request->withUploadedFiles(array('test' => 'world'));
        $this->assertNotSame($request, $this->request);
        $this->assertEquals(array('test' => 'world'), $request->getUploadedFiles());
    }
    public function testWithParsedBody()
    {
        $request = $this->request->withParsedBody(array('test' => 'world'));
        $this->assertNotSame($request, $this->request);
        $this->assertEquals(array('test' => 'world'), $request->getParsedBody());
    }
}
\class_alias('_PhpScoper26e51eeacccf\\ServerRequestTest', 'ServerRequestTest', \false);
