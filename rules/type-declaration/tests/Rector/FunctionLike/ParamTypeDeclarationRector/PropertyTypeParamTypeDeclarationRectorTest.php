<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\Tests\Rector\FunctionLike\ParamTypeDeclarationRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyTypeParamTypeDeclarationRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePropertyType');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES;
    }
}
