<?php

declare (strict_types=1);
namespace Rector\Legacy\Tests\Rector\FileWithoutNamespace\AddTopIncludeRector;

use Iterator;
use Rector\Legacy\Rector\FileWithoutNamespace\AddTopIncludeRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileInfo;
final class AddTopIncludeRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : void
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
        return [\Rector\Legacy\Rector\FileWithoutNamespace\AddTopIncludeRector::class => [\Rector\Legacy\Rector\FileWithoutNamespace\AddTopIncludeRector::AUTOLOAD_FILE_PATH => '/../autoloader.php']];
    }
}
