<?php

declare (strict_types=1);
namespace Rector\Php71\Tests\Rector\BinaryOp\IsIterableRector;

use Iterator;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\Php71\Rector\BinaryOp\IsIterableRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo;
final class PolyfillRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php71\Rector\BinaryOp\IsIterableRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \Rector\Core\ValueObject\PhpVersionFeature::ITERABLE_TYPE;
    }
}
