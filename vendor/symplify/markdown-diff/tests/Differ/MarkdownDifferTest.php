<?php

declare (strict_types=1);
namespace Symplify\MarkdownDiff\Tests\Differ;

use Symplify\MarkdownDiff\Differ\MarkdownDiffer;
use Symplify\MarkdownDiff\Tests\HttpKernel\MarkdownDiffKernel;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class MarkdownDifferTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var MarkdownDiffer
     */
    private $markdownDiffer;
    protected function setUp() : void
    {
        $this->bootKernel(\Symplify\MarkdownDiff\Tests\HttpKernel\MarkdownDiffKernel::class);
        $this->markdownDiffer = self::$container->get(\Symplify\MarkdownDiff\Differ\MarkdownDiffer::class);
    }
    public function test() : void
    {
        $currentDiff = $this->markdownDiffer->diff('old code', 'new code');
        $this->assertStringEqualsFile(__DIR__ . '/Fixture/expected_diff.txt', $currentDiff);
    }
}
