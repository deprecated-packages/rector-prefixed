<?php

declare (strict_types=1);
namespace RectorPrefix20210322\Symplify\ComposerJsonManipulator\Tests\Sorter;

use Iterator;
use RectorPrefix20210322\Symplify\ComposerJsonManipulator\Sorter\ComposerPackageSorter;
use RectorPrefix20210322\Symplify\ComposerJsonManipulator\Tests\HttpKernel\ComposerJsonManipulatorKernel;
use RectorPrefix20210322\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class ComposerPackageSorterTest extends \RectorPrefix20210322\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var ComposerPackageSorter
     */
    private $composerPackageSorter;
    protected function setUp() : void
    {
        $this->bootKernel(\RectorPrefix20210322\Symplify\ComposerJsonManipulator\Tests\HttpKernel\ComposerJsonManipulatorKernel::class);
        $this->composerPackageSorter = $this->getService(\RectorPrefix20210322\Symplify\ComposerJsonManipulator\Sorter\ComposerPackageSorter::class);
    }
    /**
     * @dataProvider provideData()
     * @param array<string, string> $packages
     * @param array<string, string> $expectedSortedPackages
     */
    public function test(array $packages, array $expectedSortedPackages) : void
    {
        $sortedPackages = $this->composerPackageSorter->sortPackages($packages);
        $this->assertSame($expectedSortedPackages, $sortedPackages);
    }
    /**
     * @return Iterator<array<int, array<string, string>>>
     */
    public function provideData() : \Iterator
    {
        (yield [['symfony/console' => '^5.2', 'php' => '^8.0', 'ext-json' => '*'], ['php' => '^8.0', 'ext-json' => '*', 'symfony/console' => '^5.2']]);
    }
}
