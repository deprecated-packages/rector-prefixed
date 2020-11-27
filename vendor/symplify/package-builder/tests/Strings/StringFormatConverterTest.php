<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Tests\Strings;

use Iterator;
use _PhpScoper26e51eeacccf\PHPUnit\Framework\TestCase;
use Symplify\PackageBuilder\Strings\StringFormatConverter;
final class StringFormatConverterTest extends \_PhpScoper26e51eeacccf\PHPUnit\Framework\TestCase
{
    /**
     * @var StringFormatConverter
     */
    private $stringFormatConverter;
    protected function setUp() : void
    {
        $this->stringFormatConverter = new \Symplify\PackageBuilder\Strings\StringFormatConverter();
    }
    /**
     * @dataProvider provideCasesForCamelCaseToUnderscore()
     */
    public function testCamelCaseToUnderscore(string $input, string $expected) : void
    {
        $this->assertSame($expected, $this->stringFormatConverter->camelCaseToUnderscore($input));
    }
    public function provideCasesForCamelCaseToUnderscore() : \Iterator
    {
        (yield ['hiTom', 'hi_tom']);
        (yield ['GPWebPay', 'gp_web_pay']);
        (yield ['bMode', 'b_mode']);
    }
    /**
     * @dataProvider provideCasesForUnderscoreAndHyphenToCamelCase()
     */
    public function testUnderscoreAndHyphenToCamelCase(string $input, string $expected) : void
    {
        $this->assertSame($expected, $this->stringFormatConverter->underscoreAndHyphenToCamelCase($input));
    }
    public function provideCasesForUnderscoreAndHyphenToCamelCase() : \Iterator
    {
        (yield ['hi_tom', 'hiTom']);
        (yield ['hi-tom', 'hiTom']);
        (yield ['hi-john_doe', 'hiJohnDoe']);
    }
}
