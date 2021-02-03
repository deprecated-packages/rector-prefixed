<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\Expression\MethodCallToReturnRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\Expression\MethodCallToReturnRector;
use Rector\Transform\Tests\Rector\Expression\MethodCallToReturnRector\Source\ReturnDeny;
use Rector\Transform\ValueObject\MethodCallToReturn;
use RectorPrefix20210203\Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallToReturnRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210203\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\Expression\MethodCallToReturnRector::class => [\Rector\Transform\Rector\Expression\MethodCallToReturnRector::METHOD_CALL_WRAPS => [new \Rector\Transform\ValueObject\MethodCallToReturn(\Rector\Transform\Tests\Rector\Expression\MethodCallToReturnRector\Source\ReturnDeny::class, 'deny')]]];
    }
}
