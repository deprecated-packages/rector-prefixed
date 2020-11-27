<?php

namespace _PhpScoper006a73f0e455\RingCentral\Tests\Psr7;

use _PhpScoper006a73f0e455\RingCentral\Psr7;
use _PhpScoper006a73f0e455\RingCentral\Psr7\InflateStream;
function php53_gzencode($data)
{
    return \gzdeflate($data);
}
class InflateStreamtest extends \_PhpScoper006a73f0e455\PHPUnit_Framework_TestCase
{
    public function testInflatesStreams()
    {
        $content = \gzencode('test');
        $a = \_PhpScoper006a73f0e455\RingCentral\Psr7\stream_for($content);
        $b = new \_PhpScoper006a73f0e455\RingCentral\Psr7\InflateStream($a);
        $this->assertEquals('test', (string) $b);
    }
}
