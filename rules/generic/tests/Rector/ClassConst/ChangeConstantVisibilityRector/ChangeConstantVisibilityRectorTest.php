<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassConst\ChangeConstantVisibilityRector;
use _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject;
use _PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ClassConstantVisibilityChange;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeConstantVisibilityRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassConst\ChangeConstantVisibilityRector::class => [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassConst\ChangeConstantVisibilityRector::CLASS_CONSTANT_VISIBILITY_CHANGES => [new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ClassConstantVisibilityChange(\_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PUBLIC_CONSTANT', 'public'), new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ClassConstantVisibilityChange(\_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PROTECTED_CONSTANT', 'protected'), new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ClassConstantVisibilityChange(\_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PRIVATE_CONSTANT', 'private'), new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ClassConstantVisibilityChange('_PhpScoper0a2ac50786fa\\Rector\\Generic\\Tests\\Rector\\ClassConst\\ChangeConstantVisibilityRector\\Fixture\\Fixture2', 'TO_BE_PRIVATE_CONSTANT', 'private')]]];
    }
}
