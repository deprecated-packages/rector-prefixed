<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\RectorOrder;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * Covers https://github.com/rectorphp/rector/pull/266#issuecomment-355725764
 */
final class RectorOrderTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        // order matters
        return [\_PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector::class => [], \_PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector::class => [], \_PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector::class => []];
    }
}
