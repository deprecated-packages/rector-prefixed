<?php

namespace _PhpScoper26e51eeacccf\RingCentral\Tests\Psr7;

use _PhpScoper26e51eeacccf\RingCentral\Psr7;
use _PhpScoper26e51eeacccf\RingCentral\Psr7\InflateStream;
function php53_gzencode($data)
{
    return \gzdeflate($data);
}
class InflateStreamtest extends \_PhpScoper26e51eeacccf\PHPUnit_Framework_TestCase
{
    public function testInflatesStreams()
    {
        $content = \gzencode('test');
        $a = \_PhpScoper26e51eeacccf\RingCentral\Psr7\stream_for($content);
        $b = new \_PhpScoper26e51eeacccf\RingCentral\Psr7\InflateStream($a);
        $this->assertEquals('test', (string) $b);
    }
}
