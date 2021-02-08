<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\String_\StringToClassConstantRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\String_\StringToClassConstantRector;
use Rector\Transform\ValueObject\StringToClassConstant;
use RectorPrefix20210208\Symplify\SmartFileSystem\SmartFileInfo;
final class StringToClassConstantRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210208\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\String_\StringToClassConstantRector::class => [\Rector\Transform\Rector\String_\StringToClassConstantRector::STRINGS_TO_CLASS_CONSTANTS => [new \Rector\Transform\ValueObject\StringToClassConstant('compiler.post_dump', 'Yet\\AnotherClass', 'CONSTANT'), new \Rector\Transform\ValueObject\StringToClassConstant('compiler.to_class', 'Yet\\AnotherClass', 'class')]]];
    }
}
