<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php71\Tests\Rector\Name\ReservedObjectRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Php71\Rector\Name\ReservedObjectRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ReservedObjectRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Php71\Rector\Name\ReservedObjectRector::class => [\_PhpScopere8e811afab72\Rector\Php71\Rector\Name\ReservedObjectRector::RESERVED_KEYWORDS_TO_REPLACEMENTS => ['ReservedObject' => 'SmartObject', 'Object' => 'AnotherSmartObject']]];
    }
}
