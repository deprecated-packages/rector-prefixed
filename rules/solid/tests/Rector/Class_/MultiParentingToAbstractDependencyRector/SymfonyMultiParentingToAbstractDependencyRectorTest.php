<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\SOLID\Tests\Rector\Class_\MultiParentingToAbstractDependencyRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class SymfonyMultiParentingToAbstractDependencyRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureSymfony');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScopere8e811afab72\Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector::class => [\_PhpScopere8e811afab72\Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector::FRAMEWORK => 'symfony']];
    }
}
