<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\New_\NewToMethodCallRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\New_\NewToMethodCallRector;
use Rector\Transform\Tests\Rector\New_\NewToMethodCallRector\Source\MyClass;
use Rector\Transform\Tests\Rector\New_\NewToMethodCallRector\Source\MyClassFactory;
use Rector\Transform\ValueObject\NewToMethodCall;
use RectorPrefix20210129\Symplify\SmartFileSystem\SmartFileInfo;
final class NewToMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210129\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\New_\NewToMethodCallRector::class => [\Rector\Transform\Rector\New_\NewToMethodCallRector::NEWS_TO_METHOD_CALLS => [new \Rector\Transform\ValueObject\NewToMethodCall(\Rector\Transform\Tests\Rector\New_\NewToMethodCallRector\Source\MyClass::class, \Rector\Transform\Tests\Rector\New_\NewToMethodCallRector\Source\MyClassFactory::class, 'create')]]];
    }
}
