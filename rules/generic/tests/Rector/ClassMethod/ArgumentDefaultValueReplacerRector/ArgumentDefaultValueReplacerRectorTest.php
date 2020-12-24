<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentDefaultValueReplacerRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\DependencyInjection\\Definition', 'setScope', 0, 'Symfony\\Component\\DependencyInjection\\ContainerBuilder::SCOPE_PROTOTYPE', \false), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, [\false, \false, \true], 'Symfony\\Component\\Yaml\\Yaml::PARSE_OBJECT_FOR_MAP'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, [\false, \true], 'Symfony\\Component\\Yaml\\Yaml::PARSE_OBJECT'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, \false, 0), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, \true, 'Symfony\\Component\\Yaml\\Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Yaml\\Yaml', 'dump', 3, [\false, \true], 'Symfony\\Component\\Yaml\\Yaml::DUMP_OBJECT'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Yaml\\Yaml', 'dump', 3, \true, 'Symfony\\Component\\Yaml\\Yaml::DUMP_EXCEPTION_ON_INVALID_TYPE')]]];
    }
}
