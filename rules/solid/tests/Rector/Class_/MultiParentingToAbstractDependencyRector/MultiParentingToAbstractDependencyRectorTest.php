<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Tests\Rector\Class_\MultiParentingToAbstractDependencyRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class MultiParentingToAbstractDependencyRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector::FRAMEWORK => 'nette']];
    }
}
