<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\FuncCall\RenameFunctionRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameFunctionRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScopere8e811afab72\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::class => [\_PhpScopere8e811afab72\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::OLD_FUNCTION_TO_NEW_FUNCTION => ['view' => '_PhpScopere8e811afab72\\Laravel\\Templating\\render', 'sprintf' => '_PhpScopere8e811afab72\\Safe\\sprintf']]];
    }
}
