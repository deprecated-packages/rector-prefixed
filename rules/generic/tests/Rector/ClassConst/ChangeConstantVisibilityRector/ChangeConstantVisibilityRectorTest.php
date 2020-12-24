<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassConst\ChangeConstantVisibilityRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ClassConstantVisibilityChange;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeConstantVisibilityRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassConst\ChangeConstantVisibilityRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassConst\ChangeConstantVisibilityRector::CLASS_CONSTANT_VISIBILITY_CHANGES => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ClassConstantVisibilityChange(\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PUBLIC_CONSTANT', 'public'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ClassConstantVisibilityChange(\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PROTECTED_CONSTANT', 'protected'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ClassConstantVisibilityChange(\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PRIVATE_CONSTANT', 'private'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ClassConstantVisibilityChange('_PhpScoperb75b35f52b74\\Rector\\Generic\\Tests\\Rector\\ClassConst\\ChangeConstantVisibilityRector\\Fixture\\Fixture2', 'TO_BE_PRIVATE_CONSTANT', 'private')]]];
    }
}
