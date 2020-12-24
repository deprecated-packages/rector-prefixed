<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\SOLID\Tests\Rector\Class_\MultiParentingToAbstractDependencyRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class MultiParentingToAbstractDependencyRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a6b37af0871\Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector::class => [\_PhpScoper0a6b37af0871\Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector::FRAMEWORK => 'nette']];
    }
}
