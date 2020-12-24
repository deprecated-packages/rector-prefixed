<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp80\Tests\Rector\FunctionLike\DowngradeParamMixedTypeDeclarationRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeParamMixedTypeDeclarationRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class DowngradeParamMixedTypeDeclarationRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 8.0
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeParamMixedTypeDeclarationRector::class;
    }
}
