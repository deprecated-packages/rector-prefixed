<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Rector\Transform\Rector\New_\NewToStaticCallRector;
use _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\FromNewClass;
use _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\IntoStaticClass;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\NewToStaticCall;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class NewToStaticCallRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\New_\NewToStaticCallRector::class => [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\New_\NewToStaticCallRector::TYPE_TO_STATIC_CALLS => [new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\NewToStaticCall(\_PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\FromNewClass::class, \_PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\IntoStaticClass::class, 'run')]]];
    }
}
