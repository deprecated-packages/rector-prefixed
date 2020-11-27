<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector;

use Iterator;
use Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject;
use Rector\Generic\ValueObject\ChangeMethodVisibility;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeMethodVisibilityRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class => [\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => [new \Rector\Generic\ValueObject\ChangeMethodVisibility(\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBePublicMethod', 'public'), new \Rector\Generic\ValueObject\ChangeMethodVisibility(\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBeProtectedMethod', 'protected'), new \Rector\Generic\ValueObject\ChangeMethodVisibility(\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBePrivateMethod', 'private'), new \Rector\Generic\ValueObject\ChangeMethodVisibility(\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBePublicStaticMethod', 'public')]]];
    }
}
