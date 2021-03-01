<?php

declare (strict_types=1);
namespace RectorPrefix20210301\Symplify\PackageBuilder\Tests\Strings;

use Iterator;
use RectorPrefix20210301\PHPUnit\Framework\TestCase;
use RectorPrefix20210301\Symplify\PackageBuilder\Strings\StringFormatConverter;
final class StringFormatConverterTest extends \RectorPrefix20210301\PHPUnit\Framework\TestCase
{
    /**
     * @var StringFormatConverter
     */
    private $stringFormatConverter;
    protected function setUp() : void
    {
        $this->stringFormatConverter = new \RectorPrefix20210301\Symplify\PackageBuilder\Strings\StringFormatConverter();
    }
    /**
     * @dataProvider provideCasesForCamelCaseToUnderscore()
     */
    public function testCamelCaseToUnderscore(string $input, string $expectedUnderscored) : void
    {
        $underscoredString = $this->stringFormatConverter->camelCaseToUnderscore($input);
        $this->assertSame($expectedUnderscored, $underscoredString);
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
        $camelCaseString = $this->stringFormatConverter->underscoreAndHyphenToCamelCase($input);
        $this->assertSame($expected, $camelCaseString);
    }
    public function provideCasesForUnderscoreAndHyphenToCamelCase() : \Iterator
    {
        (yield ['hi_tom', 'hiTom']);
        (yield ['hi-tom', 'hiTom']);
        (yield ['hi-john_doe', 'hiJohnDoe']);
    }
}
