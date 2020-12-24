<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\DifferentClass;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameClassConstantRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::CLASS_CONSTANT_RENAME => [new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'PRE_BIND', 'PRE_SUBMIT'), new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'BIND', 'SUBMIT'), new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'POST_BIND', 'POST_SUBMIT'), new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'OLD_CONSTANT', \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\DifferentClass::class . '::NEW_CONSTANT')]]];
    }
}
