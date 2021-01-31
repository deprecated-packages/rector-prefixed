<?php

declare (strict_types=1);
namespace RectorPrefix20210131\Symplify\EasyTesting\Tests\DataProvider\StaticFixtureFinder;

use RectorPrefix20210131\PHPUnit\Framework\TestCase;
use RectorPrefix20210131\Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use RectorPrefix20210131\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class StaticFixtureFinderTest extends \RectorPrefix20210131\PHPUnit\Framework\TestCase
{
    public function testYieldDirectory() : void
    {
        $files = \RectorPrefix20210131\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory(__DIR__ . '/Fixture', '*.php');
        $files = \iterator_to_array($files);
        $this->assertCount(1, $files);
    }
    public function testYieldDirectoryThrowException() : void
    {
        $this->expectException(\RectorPrefix20210131\Symplify\SymplifyKernel\Exception\ShouldNotHappenException::class);
        $this->expectExceptionMessage('"foo.txt" has invalid suffix, use "*.php" suffix instead');
        $files = \RectorPrefix20210131\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory(__DIR__ . '/FixtureMulti', '*.php');
        \iterator_to_array($files);
    }
    public function testYieldDirectoryExclusively() : void
    {
        $files = \RectorPrefix20210131\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectoryExclusively(__DIR__ . '/FixtureMulti', '*.php');
        $files = \iterator_to_array($files);
        $this->assertCount(1, $files);
    }
}
