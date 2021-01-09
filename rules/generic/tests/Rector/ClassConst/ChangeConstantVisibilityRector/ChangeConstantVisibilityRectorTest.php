<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector;

use Iterator;
use Rector\Core\ValueObject\Visibility;
use Rector\Generic\Rector\ClassConst\ChangeConstantVisibilityRector;
use Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject;
use Rector\Generic\ValueObject\ClassConstantVisibilityChange;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210109\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeConstantVisibilityRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210109\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\ClassConst\ChangeConstantVisibilityRector::class => [\Rector\Generic\Rector\ClassConst\ChangeConstantVisibilityRector::CLASS_CONSTANT_VISIBILITY_CHANGES => [new \Rector\Generic\ValueObject\ClassConstantVisibilityChange(\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PUBLIC_CONSTANT', \Rector\Core\ValueObject\Visibility::PUBLIC), new \Rector\Generic\ValueObject\ClassConstantVisibilityChange(\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PROTECTED_CONSTANT', \Rector\Core\ValueObject\Visibility::PROTECTED), new \Rector\Generic\ValueObject\ClassConstantVisibilityChange(\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PRIVATE_CONSTANT', \Rector\Core\ValueObject\Visibility::PRIVATE), new \Rector\Generic\ValueObject\ClassConstantVisibilityChange('Rector\\Generic\\Tests\\Rector\\ClassConst\\ChangeConstantVisibilityRector\\Fixture\\Fixture2', 'TO_BE_PRIVATE_CONSTANT', \Rector\Core\ValueObject\Visibility::PRIVATE)]]];
    }
}
