<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\Persister;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\RemoveInTheMiddle;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentRemover;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symfony\Component\Yaml\Yaml;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentRemoverRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentRemover(\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\Persister::class, 'getSelectJoinColumnSQL', 4, null), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentRemover(\_PhpScoperb75b35f52b74\Symfony\Component\Yaml\Yaml::class, 'parse', 1, ['Symfony\\Component\\Yaml\\Yaml::PARSE_KEYS_AS_STRINGS', 'hey', 55, 5.5]), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentRemover(\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\RemoveInTheMiddle::class, 'run', 1, ['name' => 'second'])]]];
    }
}
