<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\FunctionLike\ReturnTypeDeclarationRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210226\Symplify\SmartFileSystem\SmartFileInfo;
final class Php80RectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210226\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureForPhp80');
    }
    protected function provideConfigFilePath() : string
    {
        return __DIR__ . '/config/php_80.php';
    }
}
