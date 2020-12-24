<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\RenameMethodCallBasedOnParameterRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector\Source\SomeModelType;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameMethodCallBasedOnParameterRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\RenameMethodCallBasedOnParameterRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\RenameMethodCallBasedOnParameterRector::CALLS_WITH_PARAM_RENAMES => [new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter(\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector\Source\SomeModelType::class, 'getParam', 'paging', 'getAttribute'), new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter(\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector\Source\SomeModelType::class, 'withParam', 'paging', 'withAttribute')]]];
    }
}
