<?php

declare (strict_types=1);
namespace Rector\DependencyInjection\Tests\Rector\Class_\MultiParentingToAbstractDependencyRector;

use Iterator;
use Rector\Core\ValueObject\FrameworkName;
use Rector\DependencyInjection\Rector\Class_\MultiParentingToAbstractDependencyRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210122\Symplify\SmartFileSystem\SmartFileInfo;
final class MultiParentingToAbstractDependencyRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210122\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\DependencyInjection\Rector\Class_\MultiParentingToAbstractDependencyRector::class => [\Rector\DependencyInjection\Rector\Class_\MultiParentingToAbstractDependencyRector::FRAMEWORK => \Rector\Core\ValueObject\FrameworkName::NETTE]];
    }
}
