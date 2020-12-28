<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\MethodCall\MethodCallToPropertyFetchRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector;
use RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallToPropertyFetchRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector::class => [\Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector::METHOD_CALL_TO_PROPERTY_FETCHES => ['getEntityManager' => 'entityManager']]];
    }
}
