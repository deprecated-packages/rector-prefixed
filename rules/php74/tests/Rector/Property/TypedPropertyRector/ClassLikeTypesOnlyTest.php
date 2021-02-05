<?php

declare (strict_types=1);
namespace Rector\Php74\Tests\Rector\Property\TypedPropertyRector;

use Iterator;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileInfo;
final class ClassLikeTypesOnlyTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureClassLikeTypeOnly');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\Php74\Rector\Property\TypedPropertyRector::class => [\Rector\Php74\Rector\Property\TypedPropertyRector::CLASS_LIKE_TYPE_ONLY => \true]];
    }
}
