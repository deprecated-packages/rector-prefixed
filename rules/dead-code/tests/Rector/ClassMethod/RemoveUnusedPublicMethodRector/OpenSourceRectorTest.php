<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\ClassMethod\RemoveUnusedPublicMethodRector;

use Iterator;
use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\ProjectType;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPublicMethodRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileInfo;
final class OpenSourceRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\Rector\Core\Configuration\Option::PROJECT_TYPE, \Rector\Core\ValueObject\ProjectType::OPEN_SOURCE);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureOpenSource');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPublicMethodRector::class;
    }
}
