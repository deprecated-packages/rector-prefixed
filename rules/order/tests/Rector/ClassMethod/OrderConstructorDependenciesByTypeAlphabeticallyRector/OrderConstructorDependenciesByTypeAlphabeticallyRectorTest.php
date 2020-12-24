<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Order\Tests\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Order\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class OrderConstructorDependenciesByTypeAlphabeticallyRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Order\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector::class => [\_PhpScopere8e811afab72\Rector\Order\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector::SKIP_PATTERNS => ['*skip_pattern_setting*']]];
    }
}
