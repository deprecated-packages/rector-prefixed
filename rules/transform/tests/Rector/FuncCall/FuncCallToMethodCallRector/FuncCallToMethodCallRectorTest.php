<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source\SomeTranslator;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\FuncNameToMethodCallName;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class FuncCallToMethodCallRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::FUNC_CALL_TO_CLASS_METHOD_CALL => [new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\FuncNameToMethodCallName('view', '_PhpScoper2a4e7ab1ecbc\\Namespaced\\SomeRenderer', 'render'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\FuncNameToMethodCallName('translate', \_PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source\SomeTranslator::class, 'translateMethod'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScoper2a4e7ab1ecbc\\Rector\\Generic\\Tests\\Rector\\Function_\\FuncCallToMethodCallRector\\Source\\some_view_function', '_PhpScoper2a4e7ab1ecbc\\Namespaced\\SomeRenderer', 'render')]]];
    }
}
