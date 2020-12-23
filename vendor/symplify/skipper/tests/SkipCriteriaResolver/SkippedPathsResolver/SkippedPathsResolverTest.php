<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\SkipCriteriaResolver\SkippedPathsResolver;

use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\HttpKernel\SkipperKernel;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver;
final class SkippedPathsResolverTest extends \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var SkippedPathsResolver
     */
    private $skippedPathsResolver;
    protected function setUp() : void
    {
        $this->bootKernelWithConfigs(\_PhpScoper0a2ac50786fa\Symplify\Skipper\HttpKernel\SkipperKernel::class, [__DIR__ . '/config/config.php']);
        $this->skippedPathsResolver = $this->getService(\_PhpScoper0a2ac50786fa\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver::class);
    }
    public function test() : void
    {
        $skippedPaths = $this->skippedPathsResolver->resolve();
        $this->assertCount(2, $skippedPaths);
        $this->assertSame('*/Mask/*', $skippedPaths[1]);
    }
}
