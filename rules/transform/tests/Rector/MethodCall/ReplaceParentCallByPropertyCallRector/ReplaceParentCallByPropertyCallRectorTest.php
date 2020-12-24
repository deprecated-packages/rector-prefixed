<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\MethodCall\ReplaceParentCallByPropertyCallRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector;
use _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\MethodCall\ReplaceParentCallByPropertyCallRector\Source\TypeClassToReplaceMethodCallBy;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ReplaceParentCallByPropertyCallRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector::class => [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector::PARENT_CALLS_TO_PROPERTIES => [new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall(\_PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\MethodCall\ReplaceParentCallByPropertyCallRector\Source\TypeClassToReplaceMethodCallBy::class, 'someMethod', 'someProperty')]]];
    }
}
