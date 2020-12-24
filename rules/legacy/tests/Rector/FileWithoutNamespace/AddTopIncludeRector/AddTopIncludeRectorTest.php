<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Legacy\Tests\Rector\FileWithoutNamespace\AddTopIncludeRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Legacy\Rector\FileWithoutNamespace\AddTopIncludeRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class AddTopIncludeRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : void
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
        return [\_PhpScoper0a6b37af0871\Rector\Legacy\Rector\FileWithoutNamespace\AddTopIncludeRector::class => [\_PhpScoper0a6b37af0871\Rector\Legacy\Rector\FileWithoutNamespace\AddTopIncludeRector::AUTOLOAD_FILE_PATH => '/../autoloader.php']];
    }
}
