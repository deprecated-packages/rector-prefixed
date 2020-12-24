<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\RenameMethodCallBasedOnParameterRector;
use _PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector\Source\SomeModelType;
use _PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameMethodCallBasedOnParameterRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\RenameMethodCallBasedOnParameterRector::class => [\_PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\RenameMethodCallBasedOnParameterRector::CALLS_WITH_PARAM_RENAMES => [new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter(\_PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector\Source\SomeModelType::class, 'getParam', 'paging', 'getAttribute'), new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter(\_PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector\Source\SomeModelType::class, 'withParam', 'paging', 'withAttribute')]]];
    }
}
