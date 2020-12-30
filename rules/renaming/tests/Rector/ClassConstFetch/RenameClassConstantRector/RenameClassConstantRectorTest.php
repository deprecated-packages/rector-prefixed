<?php

declare (strict_types=1);
namespace Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector;

use Iterator;
use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector;
use Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\DifferentClass;
use Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents;
use Rector\Renaming\ValueObject\RenameClassConstant;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameClassConstantRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::class => [\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::CLASS_CONSTANT_RENAME => [new \Rector\Renaming\ValueObject\RenameClassConstant(\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'PRE_BIND', 'PRE_SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstant(\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'BIND', 'SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstant(\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'POST_BIND', 'POST_SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstant(\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'OLD_CONSTANT', \Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\DifferentClass::class . '::NEW_CONSTANT')]]];
    }
}
