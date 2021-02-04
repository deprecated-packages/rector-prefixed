<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\MethodCall\CallableInMethodCallToVariableRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\MethodCall\CallableInMethodCallToVariableRector;
use Rector\Transform\Tests\Rector\MethodCall\CallableInMethodCallToVariableRector\Source\DummyCache;
use Rector\Transform\ValueObject\CallableInMethodCallToVariable;
use RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo;
final class CallableInMethodCallToVariableRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return mixed[]
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\Transform\Rector\MethodCall\CallableInMethodCallToVariableRector::class => [\Rector\Transform\Rector\MethodCall\CallableInMethodCallToVariableRector::CALLABLE_IN_METHOD_CALL_TO_VARIABLE => [new \Rector\Transform\ValueObject\CallableInMethodCallToVariable(\Rector\Transform\Tests\Rector\MethodCall\CallableInMethodCallToVariableRector\Source\DummyCache::class, 'save', 1)]]];
    }
}
