<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\Skipper\Tests\SkipCriteriaResolver\SkippedPathsResolver;

use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScopere8e811afab72\Symplify\Skipper\HttpKernel\SkipperKernel;
use _PhpScopere8e811afab72\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver;
final class SkippedPathsResolverTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var SkippedPathsResolver
     */
    private $skippedPathsResolver;
    protected function setUp() : void
    {
        $this->bootKernelWithConfigs(\_PhpScopere8e811afab72\Symplify\Skipper\HttpKernel\SkipperKernel::class, [__DIR__ . '/config/config.php']);
        $this->skippedPathsResolver = $this->getService(\_PhpScopere8e811afab72\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver::class);
    }
    public function test() : void
    {
        $skippedPaths = $this->skippedPathsResolver->resolve();
        $this->assertCount(2, $skippedPaths);
        $this->assertSame('*/Mask/*', $skippedPaths[1]);
    }
}
