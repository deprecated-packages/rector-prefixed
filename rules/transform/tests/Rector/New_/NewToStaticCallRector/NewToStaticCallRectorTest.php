<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Rector\Transform\Rector\New_\NewToStaticCallRector;
use _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\FromNewClass;
use _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\IntoStaticClass;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\NewToStaticCall;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class NewToStaticCallRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\New_\NewToStaticCallRector::class => [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\New_\NewToStaticCallRector::TYPE_TO_STATIC_CALLS => [new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\NewToStaticCall(\_PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\FromNewClass::class, \_PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\IntoStaticClass::class, 'run')]]];
    }
}
