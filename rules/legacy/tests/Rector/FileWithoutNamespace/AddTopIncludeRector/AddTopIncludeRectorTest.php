<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Legacy\Tests\Rector\FileWithoutNamespace\AddTopIncludeRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Legacy\Rector\FileWithoutNamespace\AddTopIncludeRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class AddTopIncludeRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : void
    {
        $this->doTestFileInfo($fixtureFileInfo);
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
        return [\_PhpScopere8e811afab72\Rector\Legacy\Rector\FileWithoutNamespace\AddTopIncludeRector::class => [\_PhpScopere8e811afab72\Rector\Legacy\Rector\FileWithoutNamespace\AddTopIncludeRector::AUTOLOAD_FILE_PATH => '/../autoloader.php']];
    }
}
