<?php

declare (strict_types=1);
namespace Rector\RectorGenerator\Tests\Provider;

use Rector\Core\HttpKernel\RectorKernel;
use Rector\RectorGenerator\Provider\PackageNamesProvider;
use RectorPrefix20210105\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class PackageNamesProviderTest extends \RectorPrefix20210105\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var PackageNamesProvider
     */
    private $packageNamesProvider;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->packageNamesProvider = $this->getService(\Rector\RectorGenerator\Provider\PackageNamesProvider::class);
    }
    public function test() : void
    {
        $packageNames = $this->packageNamesProvider->provide();
        $packageNameCount = \count($packageNames);
        $this->assertGreaterThan(70, $packageNameCount);
        $this->assertContains('DeadCode', $packageNames);
        $this->assertContains('Symfony5', $packageNames);
    }
}
