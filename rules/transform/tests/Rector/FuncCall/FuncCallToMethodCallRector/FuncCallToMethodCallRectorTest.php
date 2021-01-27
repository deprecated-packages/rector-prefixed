<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector;
use Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source\SomeTranslator;
use Rector\Transform\ValueObject\FuncNameToMethodCallName;
use RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo;
final class FuncCallToMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::class => [\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::FUNC_CALL_TO_CLASS_METHOD_CALL => [new \Rector\Transform\ValueObject\FuncNameToMethodCallName('view', 'Namespaced\\SomeRenderer', 'render'), new \Rector\Transform\ValueObject\FuncNameToMethodCallName('translate', \Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source\SomeTranslator::class, 'translateMethod'), new \Rector\Transform\ValueObject\FuncNameToMethodCallName('Rector\\Generic\\Tests\\Rector\\Function_\\FuncCallToMethodCallRector\\Source\\some_view_function', 'Namespaced\\SomeRenderer', 'render')]]];
    }
}
