<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php74\Tests\Rector\Property\TypedPropertyRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Php74\Rector\Property\TypedPropertyRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ClassLikeTypesOnlyTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureClassLikeTypeOnly');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScopere8e811afab72\Rector\Php74\Rector\Property\TypedPropertyRector::class => [\_PhpScopere8e811afab72\Rector\Php74\Rector\Property\TypedPropertyRector::CLASS_LIKE_TYPE_ONLY => \true]];
    }
}
