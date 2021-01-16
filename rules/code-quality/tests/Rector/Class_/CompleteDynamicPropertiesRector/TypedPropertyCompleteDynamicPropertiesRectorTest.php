<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\Class_\CompleteDynamicPropertiesRector;

use Iterator;
use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210116\Symplify\SmartFileSystem\SmartFileInfo;
final class TypedPropertyCompleteDynamicPropertiesRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210116\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureTypedProperty');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES;
    }
}
