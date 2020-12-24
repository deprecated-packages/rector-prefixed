<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Tests\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @requires PHP 7.4
 */
final class Php74Test extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePhp74');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector::class;
    }
}
