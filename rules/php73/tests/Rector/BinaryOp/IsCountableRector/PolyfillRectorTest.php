<?php

declare (strict_types=1);
namespace Rector\Php73\Tests\Rector\BinaryOp\IsCountableRector;

use Iterator;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\Php73\Rector\BinaryOp\IsCountableRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210107\Symplify\SmartFileSystem\SmartFileInfo;
final class PolyfillRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210107\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureWithPolyfill');
    }
    protected function getPhpVersion() : int
    {
        return \Rector\Core\ValueObject\PhpVersionFeature::IS_COUNTABLE - 1;
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php73\Rector\BinaryOp\IsCountableRector::class;
    }
}
