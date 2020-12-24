<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\RectorOrder;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * Covers https://github.com/rectorphp/rector/pull/266#issuecomment-355725764
 */
final class RectorOrderTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector::class => [], \_PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector::class => [], \_PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector::class => []];
    }
}
