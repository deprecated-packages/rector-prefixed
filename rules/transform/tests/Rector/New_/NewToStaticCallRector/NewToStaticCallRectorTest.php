<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\New_\NewToStaticCallRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\New_\NewToStaticCallRector;
use Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\FromNewClass;
use Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\IntoStaticClass;
use Rector\Transform\ValueObject\NewToStaticCall;
use Symplify\SmartFileSystem\SmartFileInfo;
final class NewToStaticCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\Rector\Transform\Rector\New_\NewToStaticCallRector::class => [\Rector\Transform\Rector\New_\NewToStaticCallRector::TYPE_TO_STATIC_CALLS => [new \Rector\Transform\ValueObject\NewToStaticCall(\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\FromNewClass::class, \Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\IntoStaticClass::class, 'run')]]];
    }
}
