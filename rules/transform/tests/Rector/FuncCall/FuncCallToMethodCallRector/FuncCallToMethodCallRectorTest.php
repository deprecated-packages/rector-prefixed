<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector;
use _PhpScoper0a2ac50786fa\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source\SomeTranslator;
use _PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\FuncNameToMethodCallName;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class FuncCallToMethodCallRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a2ac50786fa\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::class => [\_PhpScoper0a2ac50786fa\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::FUNC_CALL_TO_CLASS_METHOD_CALL => [new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\FuncNameToMethodCallName('view', '_PhpScoper0a2ac50786fa\\Namespaced\\SomeRenderer', 'render'), new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\FuncNameToMethodCallName('translate', \_PhpScoper0a2ac50786fa\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source\SomeTranslator::class, 'translateMethod'), new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScoper0a2ac50786fa\\Rector\\Generic\\Tests\\Rector\\Function_\\FuncCallToMethodCallRector\\Source\\some_view_function', '_PhpScoper0a2ac50786fa\\Namespaced\\SomeRenderer', 'render')]]];
    }
}
