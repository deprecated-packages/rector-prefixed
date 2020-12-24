<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\New_\NewToStaticCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\FromNewClass;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\IntoStaticClass;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\NewToStaticCall;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class NewToStaticCallRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\New_\NewToStaticCallRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\New_\NewToStaticCallRector::TYPE_TO_STATIC_CALLS => [new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\NewToStaticCall(\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\FromNewClass::class, \_PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\IntoStaticClass::class, 'run')]]];
    }
}
