<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\MethodCall\VariableMethodCallToServiceCallRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\MethodCall\VariableMethodCallToServiceCallRector;
use Rector\Transform\ValueObject\VariableMethodCallToServiceCall;
use RectorPrefix20210131\Symplify\SmartFileSystem\SmartFileInfo;
final class VariableMethodCallToServiceCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210131\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\MethodCall\VariableMethodCallToServiceCallRector::class => [\Rector\Transform\Rector\MethodCall\VariableMethodCallToServiceCallRector::VARIABLE_METHOD_CALLS_TO_SERVICE_CALLS => [new \Rector\Transform\ValueObject\VariableMethodCallToServiceCall('PhpParser\\Node', 'getAttribute', 'php_doc_info', 'Rector\\BetterPhpDocParser\\PhpDocInfo\\PhpDocInfoFactory', 'createFromNodeOrEmpty')]]];
    }
}
