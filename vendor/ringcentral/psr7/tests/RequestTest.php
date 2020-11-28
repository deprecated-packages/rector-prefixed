<?php

namespace _PhpScoperabd03f0baf05\RingCentral\Tests\Psr7;

use _PhpScoperabd03f0baf05\RingCentral\Psr7\Request;
use _PhpScoperabd03f0baf05\RingCentral\Psr7\Uri;
/**
 * @covers RingCentral\Psr7\Request
 */
class RequestTest extends \_PhpScoperabd03f0baf05\PHPUnit_Framework_TestCase
{
    public function testRequestUriMayBeString()
    {
        $r = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', '/');
        $this->assertEquals('/', (string) $r->getUri());
    }
    public function testRequestUriMayBeUri()
    {
        $uri = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Uri('/');
        $r = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', $uri);
        $this->assertSame($uri, $r->getUri());
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidateRequestUri()
    {
        new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', \true);
    }
    public function testCanConstructWithBody()
    {
        $r = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', '/', array(), 'baz');
        $this->assertEquals('baz', (string) $r->getBody());
    }
    public function testCapitalizesMethod()
    {
        $r = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('get', '/');
        $this->assertEquals('GET', $r->getMethod());
    }
    public function testCapitalizesWithMethod()
    {
        $r = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', '/');
        $this->assertEquals('PUT', $r->withMethod('put')->getMethod());
    }
    public function testWithUri()
    {
        $r1 = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', '/');
        $u1 = $r1->getUri();
        $u2 = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Uri('http://www.example.com');
        $r2 = $r1->withUri($u2);
        $this->assertNotSame($r1, $r2);
        $this->assertSame($u2, $r2->getUri());
        $this->assertSame($u1, $r1->getUri());
    }
    public function testSameInstanceWhenSameUri()
    {
        $r1 = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', 'http://foo.com');
        $r2 = $r1->withUri($r1->getUri());
        $this->assertSame($r1, $r2);
    }
    public function testWithRequestTarget()
    {
        $r1 = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', '/');
        $r2 = $r1->withRequestTarget('*');
        $this->assertEquals('*', $r2->getRequestTarget());
        $this->assertEquals('/', $r1->getRequestTarget());
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRequestTargetDoesNotAllowSpaces()
    {
        $r1 = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', '/');
        $r1->withRequestTarget('/foo bar');
    }
    public function testRequestTargetDefaultsToSlash()
    {
        $r1 = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', '');
        $this->assertEquals('/', $r1->getRequestTarget());
        $r2 = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', '*');
        $this->assertEquals('*', $r2->getRequestTarget());
        $r3 = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', 'http://foo.com/bar baz/');
        $this->assertEquals('/bar%20baz/', $r3->getRequestTarget());
    }
    public function testBuildsRequestTarget()
    {
        $r1 = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', 'http://foo.com/baz?bar=bam');
        $this->assertEquals('/baz?bar=bam', $r1->getRequestTarget());
    }
    public function testHostIsAddedFirst()
    {
        $r = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', 'http://foo.com/baz?bar=bam', array('Foo' => 'Bar'));
        $this->assertEquals(array('Host' => array('foo.com'), 'Foo' => array('Bar')), $r->getHeaders());
    }
    public function testCanGetHeaderAsCsv()
    {
        $r = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', 'http://foo.com/baz?bar=bam', array('Foo' => array('a', 'b', 'c')));
        $this->assertEquals('a, b, c', $r->getHeaderLine('Foo'));
        $this->assertEquals('', $r->getHeaderLine('Bar'));
    }
    public function testHostIsNotOverwrittenWhenPreservingHost()
    {
        $r = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', 'http://foo.com/baz?bar=bam', array('Host' => 'a.com'));
        $this->assertEquals(array('Host' => array('a.com')), $r->getHeaders());
        $r2 = $r->withUri(new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Uri('http://www.foo.com/bar'), \true);
        $this->assertEquals('a.com', $r2->getHeaderLine('Host'));
    }
    public function testOverridesHostWithUri()
    {
        $r = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', 'http://foo.com/baz?bar=bam');
        $this->assertEquals(array('Host' => array('foo.com')), $r->getHeaders());
        $r2 = $r->withUri(new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Uri('http://www.baz.com/bar'));
        $this->assertEquals('www.baz.com', $r2->getHeaderLine('Host'));
    }
    public function testAggregatesHeaders()
    {
        $r = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', 'http://foo.com', array('ZOO' => 'zoobar', 'zoo' => array('foobar', 'zoobar')));
        $this->assertEquals('zoobar, foobar, zoobar', $r->getHeaderLine('zoo'));
    }
    public function testAddsPortToHeader()
    {
        $r = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', 'http://foo.com:8124/bar');
        $this->assertEquals('foo.com:8124', $r->getHeaderLine('host'));
    }
    public function testAddsPortToHeaderAndReplacePreviousPort()
    {
        $r = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Request('GET', 'http://foo.com:8124/bar');
        $r = $r->withUri(new \_PhpScoperabd03f0baf05\RingCentral\Psr7\Uri('http://foo.com:8125/bar'));
        $this->assertEquals('foo.com:8125', $r->getHeaderLine('host'));
    }
}
