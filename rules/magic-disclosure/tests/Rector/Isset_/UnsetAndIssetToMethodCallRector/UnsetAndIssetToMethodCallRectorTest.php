<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\MagicDisclosure\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\MagicDisclosure\Rector\Isset_\UnsetAndIssetToMethodCallRector;
use _PhpScoperb75b35f52b74\Rector\MagicDisclosure\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector\Source\LocalContainer;
use _PhpScoperb75b35f52b74\Rector\MagicDisclosure\ValueObject\IssetUnsetToMethodCall;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class UnsetAndIssetToMethodCallRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\MagicDisclosure\Rector\Isset_\UnsetAndIssetToMethodCallRector::class => [\_PhpScoperb75b35f52b74\Rector\MagicDisclosure\Rector\Isset_\UnsetAndIssetToMethodCallRector::ISSET_UNSET_TO_METHOD_CALL => [new \_PhpScoperb75b35f52b74\Rector\MagicDisclosure\ValueObject\IssetUnsetToMethodCall(\_PhpScoperb75b35f52b74\Rector\MagicDisclosure\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector\Source\LocalContainer::class, 'hasService', 'removeService')]]];
    }
}
