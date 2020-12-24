<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\StaticCall\StaticCallToFuncCallRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\StaticCall\StaticCallToFuncCallRector\Source\SomeOldStaticClass;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\StaticCallToFuncCall;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticCallToFuncCallRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::class => [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::STATIC_CALLS_TO_FUNCTIONS => [new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\StaticCallToFuncCall(\_PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\StaticCall\StaticCallToFuncCallRector\Source\SomeOldStaticClass::class, 'render', 'view')]]];
    }
}
