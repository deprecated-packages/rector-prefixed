<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Tests\SkipCriteriaResolver\SkippedPathsResolver;

use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\Skipper\HttpKernel\SkipperKernel;
use _PhpScoper2a4e7ab1ecbc\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver;
final class SkippedPathsResolverTest extends \_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var SkippedPathsResolver
     */
    private $skippedPathsResolver;
    protected function setUp() : void
    {
        $this->bootKernelWithConfigs(\_PhpScoper2a4e7ab1ecbc\Symplify\Skipper\HttpKernel\SkipperKernel::class, [__DIR__ . '/config/config.php']);
        $this->skippedPathsResolver = $this->getService(\_PhpScoper2a4e7ab1ecbc\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver::class);
    }
    public function test() : void
    {
        $skippedPaths = $this->skippedPathsResolver->resolve();
        $this->assertCount(2, $skippedPaths);
        $this->assertSame('*/Mask/*', $skippedPaths[1]);
    }
}
