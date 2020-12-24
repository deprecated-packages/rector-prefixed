<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php74\Tests\Rector\LNumber\AddLiteralSeparatorToNumberRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class AddLiteralSeparatorToNumberRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector::class => [\_PhpScoper0a6b37af0871\Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector::LIMIT_VALUE => 1000000]];
    }
}
