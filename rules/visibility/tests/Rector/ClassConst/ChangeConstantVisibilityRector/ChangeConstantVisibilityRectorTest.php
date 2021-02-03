<?php

declare (strict_types=1);
namespace Rector\Visibility\Tests\Rector\ClassConst\ChangeConstantVisibilityRector;

use Iterator;
use Rector\Core\ValueObject\Visibility;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Visibility\Rector\ClassConst\ChangeConstantVisibilityRector;
use Rector\Visibility\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject;
use Rector\Visibility\ValueObject\ClassConstantVisibilityChange;
use RectorPrefix20210203\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeConstantVisibilityRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210203\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Visibility\Rector\ClassConst\ChangeConstantVisibilityRector::class => [\Rector\Visibility\Rector\ClassConst\ChangeConstantVisibilityRector::CLASS_CONSTANT_VISIBILITY_CHANGES => [new \Rector\Visibility\ValueObject\ClassConstantVisibilityChange(\Rector\Visibility\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PUBLIC_CONSTANT', \Rector\Core\ValueObject\Visibility::PUBLIC), new \Rector\Visibility\ValueObject\ClassConstantVisibilityChange(\Rector\Visibility\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PROTECTED_CONSTANT', \Rector\Core\ValueObject\Visibility::PROTECTED), new \Rector\Visibility\ValueObject\ClassConstantVisibilityChange(\Rector\Visibility\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PRIVATE_CONSTANT', \Rector\Core\ValueObject\Visibility::PRIVATE), new \Rector\Visibility\ValueObject\ClassConstantVisibilityChange('Rector\\Visibility\\Tests\\Rector\\ClassConst\\ChangeConstantVisibilityRector\\Fixture\\Fixture2', 'TO_BE_PRIVATE_CONSTANT', \Rector\Core\ValueObject\Visibility::PRIVATE)]]];
    }
}
