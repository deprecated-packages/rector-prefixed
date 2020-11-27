<?php

namespace _PhpScoper26e51eeacccf\RingCentral\Tests\Psr7;

use _PhpScoper26e51eeacccf\RingCentral\Psr7\BufferStream;
use _PhpScoper26e51eeacccf\RingCentral\Psr7\DroppingStream;
class DroppingStreamTest extends \_PhpScoper26e51eeacccf\PHPUnit_Framework_TestCase
{
    public function testBeginsDroppingWhenSizeExceeded()
    {
        $stream = new \_PhpScoper26e51eeacccf\RingCentral\Psr7\BufferStream();
        $drop = new \_PhpScoper26e51eeacccf\RingCentral\Psr7\DroppingStream($stream, 5);
        $this->assertEquals(3, $drop->write('hel'));
        $this->assertEquals(2, $drop->write('lo'));
        $this->assertEquals(5, $drop->getSize());
        $this->assertEquals('hello', $drop->read(5));
        $this->assertEquals(0, $drop->getSize());
        $drop->write('12345678910');
        $this->assertEquals(5, $stream->getSize());
        $this->assertEquals(5, $drop->getSize());
        $this->assertEquals('12345', (string) $drop);
        $this->assertEquals(0, $drop->getSize());
        $drop->write('hello');
        $this->assertSame(0, $drop->write('test'));
    }
}
