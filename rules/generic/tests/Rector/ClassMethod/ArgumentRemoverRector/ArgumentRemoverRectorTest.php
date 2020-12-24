<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\Persister;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\RemoveInTheMiddle;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentRemover;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symfony\Component\Yaml\Yaml;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentRemoverRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => [new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentRemover(\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\Persister::class, 'getSelectJoinColumnSQL', 4, null), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentRemover(\_PhpScoper0a6b37af0871\Symfony\Component\Yaml\Yaml::class, 'parse', 1, ['Symfony\\Component\\Yaml\\Yaml::PARSE_KEYS_AS_STRINGS', 'hey', 55, 5.5]), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentRemover(\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\RemoveInTheMiddle::class, 'run', 1, ['name' => 'second'])]]];
    }
}
