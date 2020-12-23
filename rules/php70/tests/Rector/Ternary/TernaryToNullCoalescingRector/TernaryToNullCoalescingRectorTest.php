<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php70\Tests\Rector\Ternary\TernaryToNullCoalescingRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Php70\Rector\Ternary\TernaryToNullCoalescingRector;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * Some tests copied from:
 * https://github.com/FriendsOfPHP/PHP-CS-Fixer/commit/0db4f91088a3888a7c8b26e5a36fba53c0d9507c#diff-02f477b178d0dc5b25ac05ab3b59e7c7
 * https://github.com/slevomat/coding-standard/blob/master/tests/Sniffs/ControlStructures/data/requireNullCoalesceOperatorErrors.fixed.php
 */
final class TernaryToNullCoalescingRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a2ac50786fa\Rector\Php70\Rector\Ternary\TernaryToNullCoalescingRector::class;
    }
}
