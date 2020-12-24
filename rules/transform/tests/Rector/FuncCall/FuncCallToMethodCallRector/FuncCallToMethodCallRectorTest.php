<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector;
use _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source\SomeTranslator;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\FuncNameToMethodCallName;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class FuncCallToMethodCallRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::class => [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::FUNC_CALL_TO_CLASS_METHOD_CALL => [new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\FuncNameToMethodCallName('view', '_PhpScoperb75b35f52b74\\Namespaced\\SomeRenderer', 'render'), new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\FuncNameToMethodCallName('translate', \_PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source\SomeTranslator::class, 'translateMethod'), new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScoperb75b35f52b74\\Rector\\Generic\\Tests\\Rector\\Function_\\FuncCallToMethodCallRector\\Source\\some_view_function', '_PhpScoperb75b35f52b74\\Namespaced\\SomeRenderer', 'render')]]];
    }
}
