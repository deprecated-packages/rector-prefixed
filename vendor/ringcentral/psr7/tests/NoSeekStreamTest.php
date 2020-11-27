<?php

namespace _PhpScoper006a73f0e455\RingCentral\Tests\Psr7;

use _PhpScoper006a73f0e455\RingCentral\Psr7;
use _PhpScoper006a73f0e455\RingCentral\Psr7\NoSeekStream;
/**
 * @covers RingCentral\Psr7\NoSeekStream
 * @covers RingCentral\Psr7\StreamDecoratorTrait
 */
class NoSeekStreamTest extends \_PhpScoper006a73f0e455\PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Cannot seek a NoSeekStream
     */
    public function testCannotSeek()
    {
        $s = $this->getMockBuilder('_PhpScoper006a73f0e455\\Psr\\Http\\Message\\StreamInterface')->setMethods(array('isSeekable', 'seek'))->getMockForAbstractClass();
        $s->expects($this->never())->method('seek');
        $s->expects($this->never())->method('isSeekable');
        $wrapped = new \_PhpScoper006a73f0e455\RingCentral\Psr7\NoSeekStream($s);
        $this->assertFalse($wrapped->isSeekable());
        $wrapped->seek(2);
    }
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Cannot write to a non-writable stream
     */
    public function testHandlesClose()
    {
        $s = \_PhpScoper006a73f0e455\RingCentral\Psr7\stream_for('foo');
        $wrapped = new \_PhpScoper006a73f0e455\RingCentral\Psr7\NoSeekStream($s);
        $wrapped->close();
        $wrapped->write('foo');
    }
}
