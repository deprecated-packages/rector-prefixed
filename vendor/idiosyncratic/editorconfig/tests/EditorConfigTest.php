<?php

declare (strict_types=1);
namespace RectorPrefix20210507\Idiosyncratic\EditorConfig;

use RectorPrefix20210507\PHPUnit\Framework\TestCase;
use RuntimeException;
class EditorConfigTest extends \RectorPrefix20210507\PHPUnit\Framework\TestCase
{
    public function testResolvingConfigForPath() : void
    {
        $ec = new \RectorPrefix20210507\Idiosyncratic\EditorConfig\EditorConfig();
        $config = $ec->getConfigForPath(__FILE__);
        $this->assertEquals(4, $config['indent_size']->getValue());
        $config = $ec->printConfigForPath(__DIR__ . '/data/testfile.php');
        $this->assertFalse(\strpos($config, 'indent_size=4'));
    }
}
