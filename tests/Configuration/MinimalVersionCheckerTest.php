<?php

declare (strict_types=1);
namespace Rector\Core\Tests\Configuration;

use Iterator;
use Rector\Core\Configuration\MinimalVersionChecker;
use Rector\Core\Configuration\MinimalVersionChecker\ComposerJsonParser;
use Rector\Core\Configuration\MinimalVersionChecker\ComposerJsonReader;
use Rector\Core\Exception\Application\PhpVersionException;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class MinimalVersionCheckerTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function test(string $version, bool $shouldThrowException) : void
    {
        $composerJsonReader = new \Rector\Core\Configuration\MinimalVersionChecker\ComposerJsonReader(__DIR__ . '/MinimalVersionChecker/composer-7.2.0.json');
        if ($shouldThrowException) {
            $this->expectException(\Rector\Core\Exception\Application\PhpVersionException::class);
        } else {
            $this->expectNotToPerformAssertions();
        }
        $minimalVersionChecker = new \Rector\Core\Configuration\MinimalVersionChecker($version, new \Rector\Core\Configuration\MinimalVersionChecker\ComposerJsonParser($composerJsonReader->read()));
        $minimalVersionChecker->check();
    }
    public function dataProvider() : \Iterator
    {
        (yield ['7.5.0', \false]);
        (yield ['7.5.0-13ubuntu3.2', \false]);
        (yield ['7.1.0', \true]);
        (yield ['7.1.0-13ubuntu3.2', \true]);
    }
}
