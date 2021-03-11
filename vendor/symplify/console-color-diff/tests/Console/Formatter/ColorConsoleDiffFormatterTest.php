<?php

declare (strict_types=1);
namespace RectorPrefix20210311\Symplify\ConsoleColorDiff\Tests\Console\Formatter;

use Iterator;
use RectorPrefix20210311\PHPUnit\Framework\TestCase;
use RectorPrefix20210311\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter;
final class ColorConsoleDiffFormatterTest extends \RectorPrefix20210311\PHPUnit\Framework\TestCase
{
    /**
     * @var ColorConsoleDiffFormatter
     */
    private $colorConsoleDiffFormatter;
    protected function setUp() : void
    {
        $this->colorConsoleDiffFormatter = new \RectorPrefix20210311\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter();
    }
    /**
     * @dataProvider provideData()
     */
    public function test(string $content, string $expectedFormatedFileContent) : void
    {
        $formattedContent = $this->colorConsoleDiffFormatter->format($content);
        $this->assertStringEqualsFile($expectedFormatedFileContent, $formattedContent);
    }
    public function provideData() : \Iterator
    {
        (yield ['...', __DIR__ . '/Source/expected/expected.txt']);
        (yield ["-old\n+new", __DIR__ . '/Source/expected/expected_old_new.txt']);
    }
}
