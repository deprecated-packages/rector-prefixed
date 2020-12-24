<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DowngradePhp80\Tests\Rector\FunctionLike\DowngradeReturnMixedTypeDeclarationRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeReturnMixedTypeDeclarationRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class DowngradeReturnMixedTypeDeclarationRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 8.0
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
    protected function getRectorClass() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeReturnMixedTypeDeclarationRector::class;
    }
}
