<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector;

use Iterator;
use Rector\Generic\Rector\Expression\MethodCallToReturnRector;
use Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector\Source\ReturnDeny;
use Rector\Generic\ValueObject\MethodCallToReturn;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210121\Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallToReturnRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210121\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\Expression\MethodCallToReturnRector::class => [\Rector\Generic\Rector\Expression\MethodCallToReturnRector::METHOD_CALL_WRAPS => [new \Rector\Generic\ValueObject\MethodCallToReturn(\Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector\Source\ReturnDeny::class, 'deny')]]];
    }
}
