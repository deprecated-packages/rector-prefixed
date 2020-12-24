<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\RenameMethodCallBasedOnParameterRector;
use _PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector\Source\SomeModelType;
use _PhpScopere8e811afab72\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameMethodCallBasedOnParameterRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    /**
     * @return Iterator
     */
    public function provideData() : iterable
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\RenameMethodCallBasedOnParameterRector::class => [\_PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\RenameMethodCallBasedOnParameterRector::CALLS_WITH_PARAM_RENAMES => [new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter(\_PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector\Source\SomeModelType::class, 'getParam', 'paging', 'getAttribute'), new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter(\_PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector\Source\SomeModelType::class, 'withParam', 'paging', 'withAttribute')]]];
    }
}
