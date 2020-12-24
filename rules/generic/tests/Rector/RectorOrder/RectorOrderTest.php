<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\RectorOrder;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * Covers https://github.com/rectorphp/rector/pull/266#issuecomment-355725764
 */
final class RectorOrderTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        // order matters
        return [\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector::class => [], \_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector::class => [], \_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector::class => []];
    }
}
