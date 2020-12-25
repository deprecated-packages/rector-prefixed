<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;

use Iterator;
use Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;
use Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentDefaultValueReplacerRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::class => [\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => [new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperf18a0c41e2d2\\Symfony\\Component\\DependencyInjection\\Definition', 'setScope', 0, 'Symfony\\Component\\DependencyInjection\\ContainerBuilder::SCOPE_PROTOTYPE', \false), new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, [\false, \false, \true], 'Symfony\\Component\\Yaml\\Yaml::PARSE_OBJECT_FOR_MAP'), new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, [\false, \true], 'Symfony\\Component\\Yaml\\Yaml::PARSE_OBJECT'), new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, \false, 0), new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, \true, 'Symfony\\Component\\Yaml\\Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE'), new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Yaml\\Yaml', 'dump', 3, [\false, \true], 'Symfony\\Component\\Yaml\\Yaml::DUMP_OBJECT'), new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperf18a0c41e2d2\\Symfony\\Component\\Yaml\\Yaml', 'dump', 3, \true, 'Symfony\\Component\\Yaml\\Yaml::DUMP_EXCEPTION_ON_INVALID_TYPE')]]];
    }
}
