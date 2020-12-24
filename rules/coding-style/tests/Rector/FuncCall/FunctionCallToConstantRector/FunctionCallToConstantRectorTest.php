<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\FuncCall\FunctionCallToConstantRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\CodingStyle\Rector\FuncCall\FunctionCallToConstantRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class FunctionCallToConstantRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\CodingStyle\Rector\FuncCall\FunctionCallToConstantRector::class => [\_PhpScopere8e811afab72\Rector\CodingStyle\Rector\FuncCall\FunctionCallToConstantRector::FUNCTIONS_TO_CONSTANTS => ['php_sapi_name' => 'PHP_SAPI', 'pi' => 'M_PI']]];
    }
}
