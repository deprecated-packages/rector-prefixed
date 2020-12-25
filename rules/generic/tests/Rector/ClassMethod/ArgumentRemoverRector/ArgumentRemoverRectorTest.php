<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector;

use Iterator;
use Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\Persister;
use Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\RemoveInTheMiddle;
use Rector\Generic\ValueObject\ArgumentRemover;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperfce0de0de1ce\Symfony\Component\Yaml\Yaml;
use Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentRemoverRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class => [\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => [new \Rector\Generic\ValueObject\ArgumentRemover(\Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\Persister::class, 'getSelectJoinColumnSQL', 4, null), new \Rector\Generic\ValueObject\ArgumentRemover(\_PhpScoperfce0de0de1ce\Symfony\Component\Yaml\Yaml::class, 'parse', 1, ['Symfony\\Component\\Yaml\\Yaml::PARSE_KEYS_AS_STRINGS', 'hey', 55, 5.5]), new \Rector\Generic\ValueObject\ArgumentRemover(\Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\RemoveInTheMiddle::class, 'run', 1, ['name' => 'second'])]]];
    }
}
