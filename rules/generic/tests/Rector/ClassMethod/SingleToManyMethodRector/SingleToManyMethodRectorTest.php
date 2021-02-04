<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\ClassMethod\SingleToManyMethodRector;

use Iterator;
use Rector\Generic\Rector\ClassMethod\SingleToManyMethodRector;
use Rector\Generic\Tests\Rector\ClassMethod\SingleToManyMethodRector\Source\OneToManyInterface;
use Rector\Generic\ValueObject\SingleToManyMethod;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo;
final class SingleToManyMethodRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\ClassMethod\SingleToManyMethodRector::class => [\Rector\Generic\Rector\ClassMethod\SingleToManyMethodRector::SINGLES_TO_MANY_METHODS => [new \Rector\Generic\ValueObject\SingleToManyMethod(\Rector\Generic\Tests\Rector\ClassMethod\SingleToManyMethodRector\Source\OneToManyInterface::class, 'getNode', 'getNodes')]]];
    }
}
