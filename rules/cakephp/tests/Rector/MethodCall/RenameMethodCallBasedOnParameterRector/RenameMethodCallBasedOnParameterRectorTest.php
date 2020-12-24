<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\RenameMethodCallBasedOnParameterRector;
use _PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector\Source\SomeModelType;
use _PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameMethodCallBasedOnParameterRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    /**
     * @return Iterator
     */
    public function provideData() : iterable
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\RenameMethodCallBasedOnParameterRector::class => [\_PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\RenameMethodCallBasedOnParameterRector::CALLS_WITH_PARAM_RENAMES => [new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter(\_PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector\Source\SomeModelType::class, 'getParam', 'paging', 'getAttribute'), new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter(\_PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector\Source\SomeModelType::class, 'withParam', 'paging', 'withAttribute')]]];
    }
}
