<?php

declare (strict_types=1);
namespace RectorPrefix20210301\Symplify\MarkdownDiff\Tests\Differ;

use RectorPrefix20210301\Symplify\MarkdownDiff\Differ\MarkdownDiffer;
use RectorPrefix20210301\Symplify\MarkdownDiff\Tests\HttpKernel\MarkdownDiffKernel;
use RectorPrefix20210301\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class MarkdownDifferTest extends \RectorPrefix20210301\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var MarkdownDiffer
     */
    private $markdownDiffer;
    protected function setUp() : void
    {
        $this->bootKernel(\RectorPrefix20210301\Symplify\MarkdownDiff\Tests\HttpKernel\MarkdownDiffKernel::class);
        $this->markdownDiffer = $this->getService(\RectorPrefix20210301\Symplify\MarkdownDiff\Differ\MarkdownDiffer::class);
    }
    public function test() : void
    {
        $currentDiff = $this->markdownDiffer->diff('old code', 'new code');
        $this->assertStringEqualsFile(__DIR__ . '/Fixture/expected_diff.txt', $currentDiff);
    }
}
