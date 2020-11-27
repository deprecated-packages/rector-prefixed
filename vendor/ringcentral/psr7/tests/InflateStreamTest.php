<?php

namespace _PhpScoperbd5d0c5f7638\RingCentral\Tests\Psr7;

use _PhpScoperbd5d0c5f7638\RingCentral\Psr7;
use _PhpScoperbd5d0c5f7638\RingCentral\Psr7\InflateStream;
function php53_gzencode($data)
{
    return \gzdeflate($data);
}
class InflateStreamtest extends \_PhpScoperbd5d0c5f7638\PHPUnit_Framework_TestCase
{
    public function testInflatesStreams()
    {
        $content = \gzencode('test');
        $a = \_PhpScoperbd5d0c5f7638\RingCentral\Psr7\stream_for($content);
        $b = new \_PhpScoperbd5d0c5f7638\RingCentral\Psr7\InflateStream($a);
        $this->assertEquals('test', (string) $b);
    }
}
