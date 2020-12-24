<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\Tests\Rector\FunctionLike\ReturnTypeDeclarationRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class Php80RectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureForPhp80');
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::STATIC_RETURN_TYPE;
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector::class;
    }
}
