<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\DifferentClass;
use _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameClassConstantRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::class => [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstantRector::CLASS_CONSTANT_RENAME => [new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant(\_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'PRE_BIND', 'PRE_SUBMIT'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant(\_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'BIND', 'SUBMIT'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant(\_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'POST_BIND', 'POST_SUBMIT'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameClassConstant(\_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\LocalFormEvents::class, 'OLD_CONSTANT', \_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\Source\DifferentClass::class . '::NEW_CONSTANT')]]];
    }
}
