<?php

declare (strict_types=1);
namespace Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector;

use Iterator;
use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector;
use Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector\Source\DifferentClass;
use Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector\Source\LocalFormEvents;
use Rector\Renaming\ValueObject\RenameClassAndConstFetch;
use Rector\Renaming\ValueObject\RenameClassConstFetch;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameClassConstFetchRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector::class => [\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector::CLASS_CONSTANT_RENAME => [new \Rector\Renaming\ValueObject\RenameClassConstFetch(\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector\Source\LocalFormEvents::class, 'PRE_BIND', 'PRE_SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstFetch(\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector\Source\LocalFormEvents::class, 'BIND', 'SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstFetch(\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector\Source\LocalFormEvents::class, 'POST_BIND', 'POST_SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch(\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector\Source\LocalFormEvents::class, 'OLD_CONSTANT', \Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector\Source\DifferentClass::class, 'NEW_CONSTANT')]]];
    }
}
