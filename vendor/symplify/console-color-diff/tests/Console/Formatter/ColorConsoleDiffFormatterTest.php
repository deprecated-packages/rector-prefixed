<?php

declare (strict_types=1);
namespace Symplify\ConsoleColorDiff\Tests\Console\Formatter;

use Iterator;
use _PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase;
use Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter;
final class ColorConsoleDiffFormatterTest extends \_PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase
{
    /**
     * @var ColorConsoleDiffFormatter
     */
    private $colorConsoleDiffFormatter;
    protected function setUp() : void
    {
        $this->colorConsoleDiffFormatter = new \Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter();
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
