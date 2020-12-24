<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\MethodCall\MethodCallToStaticCallRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Rector\Transform\Rector\MethodCall\MethodCallToStaticCallRector;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\MethodCallToStaticCall;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallToStaticCallRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\MethodCall\MethodCallToStaticCallRector::class => [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\MethodCall\MethodCallToStaticCallRector::METHOD_CALLS_TO_STATIC_CALLS => [new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\MethodCallToStaticCall(\_PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\MethodCall\MethodCallToStaticCallRector\AnotherDependency::class, 'process', 'StaticCaller', 'anotherMethod')]]];
    }
}
