<?php

declare (strict_types=1);
namespace RectorPrefix20210507\Idiosyncratic\EditorConfig\Declaration;

use DomainException;
use RectorPrefix20210507\PHPUnit\Framework\TestCase;
use RuntimeException;
class EndOfLineTest extends \RectorPrefix20210507\PHPUnit\Framework\TestCase
{
    public function testValidValues()
    {
        foreach (\RectorPrefix20210507\Idiosyncratic\EditorConfig\Declaration\EndOfLine::LINE_ENDINGS as $eol) {
            $declaration = new \RectorPrefix20210507\Idiosyncratic\EditorConfig\Declaration\EndOfLine($eol);
            $this->assertEquals(\sprintf('end_of_line=%s', $eol), (string) $declaration);
        }
    }
    public function testInvalidValues()
    {
        $this->expectException(\DomainException::class);
        $declaration = new \RectorPrefix20210507\Idiosyncratic\EditorConfig\Declaration\EndOfLine('true');
        $this->expectException(\DomainException::class);
        $declaration = new \RectorPrefix20210507\Idiosyncratic\EditorConfig\Declaration\EndOfLine('spaces');
    }
}
