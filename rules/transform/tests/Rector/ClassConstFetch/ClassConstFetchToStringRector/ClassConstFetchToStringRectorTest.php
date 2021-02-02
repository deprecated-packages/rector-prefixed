<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\ClassConstFetch\ClassConstFetchToStringRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\ClassConstFetch\ClassConstFetchToStringRector;
use Rector\Transform\Tests\Rector\ClassConstFetch\ClassConstFetchToStringRector\Source\OldClassWithConstants;
use Rector\Transform\ValueObject\ClassConstFetchToValue;
use RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo;
final class ClassConstFetchToStringRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\ClassConstFetch\ClassConstFetchToStringRector::class => [\Rector\Transform\Rector\ClassConstFetch\ClassConstFetchToStringRector::CLASS_CONST_FETCHES_TO_VALUES => [new \Rector\Transform\ValueObject\ClassConstFetchToValue(\Rector\Transform\Tests\Rector\ClassConstFetch\ClassConstFetchToStringRector\Source\OldClassWithConstants::class, 'DEVELOPMENT', 'development'), new \Rector\Transform\ValueObject\ClassConstFetchToValue(\Rector\Transform\Tests\Rector\ClassConstFetch\ClassConstFetchToStringRector\Source\OldClassWithConstants::class, 'PRODUCTION', 'production')]]];
    }
}
