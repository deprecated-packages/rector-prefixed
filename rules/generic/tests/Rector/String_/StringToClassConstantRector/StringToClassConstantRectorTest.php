<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\String_\StringToClassConstantRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\String_\StringToClassConstantRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\StringToClassConstant;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class StringToClassConstantRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\String_\StringToClassConstantRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\String_\StringToClassConstantRector::STRINGS_TO_CLASS_CONSTANTS => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\StringToClassConstant('compiler.post_dump', '_PhpScoperb75b35f52b74\\Yet\\AnotherClass', 'CONSTANT'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\StringToClassConstant('compiler.to_class', '_PhpScoperb75b35f52b74\\Yet\\AnotherClass', 'class')]]];
    }
}
