<?php

declare (strict_types=1);
namespace Rector\Removing\Tests\Rector\ClassMethod\ArgumentRemoverRector;

use Iterator;
use Rector\Removing\Rector\ClassMethod\ArgumentRemoverRector;
use Rector\Removing\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\Persister;
use Rector\Removing\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\RemoveInTheMiddle;
use Rector\Removing\ValueObject\ArgumentRemover;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210208\Symfony\Component\Yaml\Yaml;
use RectorPrefix20210208\Symplify\SmartFileSystem\SmartFileInfo;
final class ArgumentRemoverRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\Rector\Removing\Rector\ClassMethod\ArgumentRemoverRector::class => [\Rector\Removing\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => [new \Rector\Removing\ValueObject\ArgumentRemover(\Rector\Removing\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\Persister::class, 'getSelectJoinColumnSQL', 4, null), new \Rector\Removing\ValueObject\ArgumentRemover(\RectorPrefix20210208\Symfony\Component\Yaml\Yaml::class, 'parse', 1, ['Symfony\\Component\\Yaml\\Yaml::PARSE_KEYS_AS_STRINGS', 'hey', 55, 5.5]), new \Rector\Removing\ValueObject\ArgumentRemover(\Rector\Removing\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\RemoveInTheMiddle::class, 'run', 1, ['name' => 'second'])]]];
    }
}
