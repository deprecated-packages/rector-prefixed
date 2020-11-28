<?php

namespace _PhpScoperabd03f0baf05\RingCentral\Tests\Psr7;

use _PhpScoperabd03f0baf05\RingCentral\Psr7;
use _PhpScoperabd03f0baf05\RingCentral\Psr7\InflateStream;
function php53_gzencode($data)
{
    return \gzdeflate($data);
}
class InflateStreamtest extends \_PhpScoperabd03f0baf05\PHPUnit_Framework_TestCase
{
    public function testInflatesStreams()
    {
        $content = \gzencode('test');
        $a = \_PhpScoperabd03f0baf05\RingCentral\Psr7\stream_for($content);
        $b = new \_PhpScoperabd03f0baf05\RingCentral\Psr7\InflateStream($a);
        $this->assertEquals('test', (string) $b);
    }
}
