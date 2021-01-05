<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector;

use Iterator;
use Rector\Generic\Rector\MethodCall\MethodCallRemoverRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210105\Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallRemoverRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210105\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\MethodCall\MethodCallRemoverRector::class => [\Rector\Generic\Rector\MethodCall\MethodCallRemoverRector::METHOD_CALL_REMOVER_ARGUMENT => ['Rector\\Generic\\Tests\\Rector\\MethodCall\\MethodCallRemoverRector\\Source\\Car' => 'getCarType']]];
    }
}
