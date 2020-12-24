<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Tests\Rector\Return_\SimplifyUselessVariableRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\Return_\SimplifyUselessVariableRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * Tests copied from:
 * - https://github.com/slevomat/coding-standard/blob/9978172758e90bc2355573e0b5d99062d87b14a3/tests/Sniffs/Variables/data/uselessVariableErrors.fixed.php
 * - https://github.com/slevomat/coding-standard/blob/9978172758e90bc2355573e0b5d99062d87b14a3/tests/Sniffs/Variables/data/uselessVariableNoErrors.php
 */
final class SimplifyUselessVariableRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\Return_\SimplifyUselessVariableRector::class;
    }
}
