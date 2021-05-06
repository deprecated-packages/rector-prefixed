<?php

declare (strict_types=1);
namespace RectorPrefix20210506\Idiosyncratic\EditorConfig\Declaration;

use RectorPrefix20210506\Idiosyncratic\EditorConfig\Exception\InvalidValue;
use RectorPrefix20210506\PHPUnit\Framework\TestCase;
use RuntimeException;
class InsertFinalNewlineTest extends \RectorPrefix20210506\PHPUnit\Framework\TestCase
{
    public function testValidValues()
    {
        $declaration = new \RectorPrefix20210506\Idiosyncratic\EditorConfig\Declaration\InsertFinalNewline('false');
        $this->assertEquals('insert_final_newline=false', (string) $declaration);
        $declaration = new \RectorPrefix20210506\Idiosyncratic\EditorConfig\Declaration\InsertFinalNewline('true');
        $this->assertEquals('insert_final_newline=true', (string) $declaration);
    }
    public function testInvalidValues()
    {
        $this->expectException(\RectorPrefix20210506\Idiosyncratic\EditorConfig\Exception\InvalidValue::class);
        $declaration = new \RectorPrefix20210506\Idiosyncratic\EditorConfig\Declaration\InsertFinalNewline('4');
        $this->expectException(\RectorPrefix20210506\Idiosyncratic\EditorConfig\Exception\InvalidValue::class);
        $declaration = new \RectorPrefix20210506\Idiosyncratic\EditorConfig\Declaration\InsertFinalNewline('four');
    }
}
