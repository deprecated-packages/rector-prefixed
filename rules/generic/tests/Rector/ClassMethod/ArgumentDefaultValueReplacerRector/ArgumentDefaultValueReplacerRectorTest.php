<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;
use _PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentDefaultValueReplacerRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::class => [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => [new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a2ac50786fa\\Symfony\\Component\\DependencyInjection\\Definition', 'setScope', 0, 'Symfony\\Component\\DependencyInjection\\ContainerBuilder::SCOPE_PROTOTYPE', \false), new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a2ac50786fa\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, [\false, \false, \true], 'Symfony\\Component\\Yaml\\Yaml::PARSE_OBJECT_FOR_MAP'), new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a2ac50786fa\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, [\false, \true], 'Symfony\\Component\\Yaml\\Yaml::PARSE_OBJECT'), new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a2ac50786fa\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, \false, 0), new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a2ac50786fa\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, \true, 'Symfony\\Component\\Yaml\\Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE'), new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a2ac50786fa\\Symfony\\Component\\Yaml\\Yaml', 'dump', 3, [\false, \true], 'Symfony\\Component\\Yaml\\Yaml::DUMP_OBJECT'), new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a2ac50786fa\\Symfony\\Component\\Yaml\\Yaml', 'dump', 3, \true, 'Symfony\\Component\\Yaml\\Yaml::DUMP_EXCEPTION_ON_INVALID_TYPE')]]];
    }
}
