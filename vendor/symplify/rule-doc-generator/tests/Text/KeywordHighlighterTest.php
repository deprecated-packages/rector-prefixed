<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\Tests\Text;

use Iterator;
use RectorPrefix20210301\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use Symplify\RuleDocGenerator\HttpKernel\RuleDocGeneratorKernel;
use Symplify\RuleDocGenerator\Text\KeywordHighlighter;
final class KeywordHighlighterTest extends \RectorPrefix20210301\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var KeywordHighlighter
     */
    private $keywordHighlighter;
    protected function setUp() : void
    {
        $this->bootKernel(\Symplify\RuleDocGenerator\HttpKernel\RuleDocGeneratorKernel::class);
        $this->keywordHighlighter = $this->getService(\Symplify\RuleDocGenerator\Text\KeywordHighlighter::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(string $inputText, string $expectedHighlightedText) : void
    {
        $highlightedText = $this->keywordHighlighter->highlight($inputText);
        $this->assertSame($expectedHighlightedText, $highlightedText);
    }
    public function provideData() : \Iterator
    {
        (yield ['some @var text', 'some `@var` text']);
        (yield ['@param @var text', '`@param` `@var` text']);
        (yield ['some @var and @param text', 'some `@var` and `@param` text']);
        (yield ['autowire(), autoconfigure(), and public() are required in config service', '`autowire()`, `autoconfigure()`, and `public()` are required in config service']);
    }
}
