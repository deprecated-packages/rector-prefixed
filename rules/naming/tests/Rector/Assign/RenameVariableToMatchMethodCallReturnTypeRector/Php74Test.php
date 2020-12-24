<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Tests\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @requires PHP 7.4
 */
final class Php74Test extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePhp74');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector::class;
    }
}
