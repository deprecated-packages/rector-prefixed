<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector\Source\OldClassWithConstants;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameClassConstantsUseToStringsRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector::OLD_CONSTANTS_TO_NEW_VALUES_BY_TYPE => [\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector\Source\OldClassWithConstants::class => ['DEVELOPMENT' => 'development', 'PRODUCTION' => 'production']]]];
    }
}
