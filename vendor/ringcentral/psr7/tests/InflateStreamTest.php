<?php

namespace _PhpScoper88fe6e0ad041\RingCentral\Tests\Psr7;

use _PhpScoper88fe6e0ad041\RingCentral\Psr7;
use _PhpScoper88fe6e0ad041\RingCentral\Psr7\InflateStream;
function php53_gzencode($data)
{
    return \gzdeflate($data);
}
class InflateStreamtest extends \_PhpScoper88fe6e0ad041\PHPUnit_Framework_TestCase
{
    public function testInflatesStreams()
    {
        $content = \gzencode('test');
        $a = \_PhpScoper88fe6e0ad041\RingCentral\Psr7\stream_for($content);
        $b = new \_PhpScoper88fe6e0ad041\RingCentral\Psr7\InflateStream($a);
        $this->assertEquals('test', (string) $b);
    }
}
