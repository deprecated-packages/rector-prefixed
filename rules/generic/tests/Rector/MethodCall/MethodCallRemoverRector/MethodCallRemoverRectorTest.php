<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\MethodCall\MethodCallRemoverRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallRemoverRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\MethodCall\MethodCallRemoverRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\MethodCall\MethodCallRemoverRector::METHOD_CALL_REMOVER_ARGUMENT => ['_PhpScoper0a6b37af0871\\Rector\\Generic\\Tests\\Rector\\MethodCall\\MethodCallRemoverRector\\Source\\Car' => 'getCarType']]];
    }
}
