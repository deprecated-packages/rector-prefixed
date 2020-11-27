<?php

namespace _PhpScopera143bcca66cb\RingCentral\Tests\Psr7;

use _PhpScopera143bcca66cb\RingCentral\Psr7;
use _PhpScopera143bcca66cb\RingCentral\Psr7\InflateStream;
function php53_gzencode($data)
{
    return \gzdeflate($data);
}
class InflateStreamtest extends \_PhpScopera143bcca66cb\PHPUnit_Framework_TestCase
{
    public function testInflatesStreams()
    {
        $content = \gzencode('test');
        $a = \_PhpScopera143bcca66cb\RingCentral\Psr7\stream_for($content);
        $b = new \_PhpScopera143bcca66cb\RingCentral\Psr7\InflateStream($a);
        $this->assertEquals('test', (string) $b);
    }
}
