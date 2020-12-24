<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector;
use _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source\SomeTranslator;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncNameToMethodCallName;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class FuncCallToMethodCallRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::class => [\_PhpScopere8e811afab72\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::FUNC_CALL_TO_CLASS_METHOD_CALL => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncNameToMethodCallName('view', '_PhpScopere8e811afab72\\Namespaced\\SomeRenderer', 'render'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncNameToMethodCallName('translate', \_PhpScopere8e811afab72\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source\SomeTranslator::class, 'translateMethod'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScopere8e811afab72\\Rector\\Generic\\Tests\\Rector\\Function_\\FuncCallToMethodCallRector\\Source\\some_view_function', '_PhpScopere8e811afab72\\Namespaced\\SomeRenderer', 'render')]]];
    }
}
