<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector;

use Iterator;
use Rector\Generic\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector;
use Rector\Generic\Tests\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector\Source\OldClassWithConstants;
use Rector\Generic\ValueObject\ClassConstFetchToValue;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameClassConstantsUseToStringsRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector::class => [\Rector\Generic\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector::CLASS_CONST_FETCHES_TO_VALUES => [new \Rector\Generic\ValueObject\ClassConstFetchToValue(\Rector\Generic\Tests\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector\Source\OldClassWithConstants::class, 'DEVELOPMENT', 'development'), new \Rector\Generic\ValueObject\ClassConstFetchToValue(\Rector\Generic\Tests\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector\Source\OldClassWithConstants::class, 'PRODUCTION', 'production')]]];
    }
}
