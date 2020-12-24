<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\MagicDisclosure\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\MagicDisclosure\Rector\Isset_\UnsetAndIssetToMethodCallRector;
use _PhpScoper0a6b37af0871\Rector\MagicDisclosure\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector\Source\LocalContainer;
use _PhpScoper0a6b37af0871\Rector\MagicDisclosure\ValueObject\IssetUnsetToMethodCall;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class UnsetAndIssetToMethodCallRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\MagicDisclosure\Rector\Isset_\UnsetAndIssetToMethodCallRector::class => [\_PhpScoper0a6b37af0871\Rector\MagicDisclosure\Rector\Isset_\UnsetAndIssetToMethodCallRector::ISSET_UNSET_TO_METHOD_CALL => [new \_PhpScoper0a6b37af0871\Rector\MagicDisclosure\ValueObject\IssetUnsetToMethodCall(\_PhpScoper0a6b37af0871\Rector\MagicDisclosure\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector\Source\LocalContainer::class, 'hasService', 'removeService')]]];
    }
}
