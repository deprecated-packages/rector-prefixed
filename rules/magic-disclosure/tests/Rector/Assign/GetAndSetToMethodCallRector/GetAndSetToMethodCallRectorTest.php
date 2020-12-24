<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\MagicDisclosure\Rector\Assign\GetAndSetToMethodCallRector;
use _PhpScopere8e811afab72\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\Klarka;
use _PhpScopere8e811afab72\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\SomeContainer;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class GetAndSetToMethodCallRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\MagicDisclosure\Rector\Assign\GetAndSetToMethodCallRector::class => [\_PhpScopere8e811afab72\Rector\MagicDisclosure\Rector\Assign\GetAndSetToMethodCallRector::TYPE_TO_METHOD_CALLS => [\_PhpScopere8e811afab72\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\SomeContainer::class => ['get' => 'getService', 'set' => 'addService'], \_PhpScopere8e811afab72\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\Klarka::class => ['get' => 'get']]]];
    }
}
