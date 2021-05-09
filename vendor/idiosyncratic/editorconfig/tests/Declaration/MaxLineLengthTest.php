<?php

declare (strict_types=1);
namespace RectorPrefix20210509\Idiosyncratic\EditorConfig\Declaration;

use RectorPrefix20210509\Idiosyncratic\EditorConfig\Exception\InvalidValue;
use RectorPrefix20210509\PHPUnit\Framework\TestCase;
class MaxLineLengthTest extends \RectorPrefix20210509\PHPUnit\Framework\TestCase
{
    public function testValidValues()
    {
        $declaration = new \RectorPrefix20210509\Idiosyncratic\EditorConfig\Declaration\MaxLineLength('off');
        $this->assertEquals('max_line_length=off', (string) $declaration);
        $declaration = new \RectorPrefix20210509\Idiosyncratic\EditorConfig\Declaration\MaxLineLength('4');
        $this->assertEquals('max_line_length=4', (string) $declaration);
        $this->assertSame(4, $declaration->getValue());
    }
    public function testInvalidValues()
    {
        $this->expectException(\RectorPrefix20210509\Idiosyncratic\EditorConfig\Exception\InvalidValue::class);
        $declaration = new \RectorPrefix20210509\Idiosyncratic\EditorConfig\Declaration\MaxLineLength('true');
        $this->expectException(\RectorPrefix20210509\Idiosyncratic\EditorConfig\Exception\InvalidValue::class);
        $declaration = new \RectorPrefix20210509\Idiosyncratic\EditorConfig\Declaration\MaxLineLength('four');
        $this->expectException(\RectorPrefix20210509\Idiosyncratic\EditorConfig\Exception\InvalidValue::class);
        $declaration = new \RectorPrefix20210509\Idiosyncratic\EditorConfig\Declaration\MaxLineLength('-1');
    }
}
