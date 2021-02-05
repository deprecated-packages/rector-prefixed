<?php

declare (strict_types=1);
namespace Rector\Php71\Tests\Rector\Name\ReservedObjectRector;

use Iterator;
use Rector\Php71\Rector\Name\ReservedObjectRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileInfo;
final class ReservedObjectRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Php71\Rector\Name\ReservedObjectRector::class => [\Rector\Php71\Rector\Name\ReservedObjectRector::RESERVED_KEYWORDS_TO_REPLACEMENTS => ['ReservedObject' => 'SmartObject', 'Object' => 'AnotherSmartObject']]];
    }
}
