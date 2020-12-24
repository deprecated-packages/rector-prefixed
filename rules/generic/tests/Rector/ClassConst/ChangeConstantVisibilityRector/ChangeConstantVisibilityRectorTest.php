<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassConst\ChangeConstantVisibilityRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ClassConstantVisibilityChange;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeConstantVisibilityRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassConst\ChangeConstantVisibilityRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassConst\ChangeConstantVisibilityRector::CLASS_CONSTANT_VISIBILITY_CHANGES => [new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ClassConstantVisibilityChange(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PUBLIC_CONSTANT', 'public'), new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ClassConstantVisibilityChange(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PROTECTED_CONSTANT', 'protected'), new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ClassConstantVisibilityChange(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PRIVATE_CONSTANT', 'private'), new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ClassConstantVisibilityChange('_PhpScoper2a4e7ab1ecbc\\Rector\\Generic\\Tests\\Rector\\ClassConst\\ChangeConstantVisibilityRector\\Fixture\\Fixture2', 'TO_BE_PRIVATE_CONSTANT', 'private')]]];
    }
}
