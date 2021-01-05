<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector;

use Iterator;
use Rector\Core\ValueObject\Visibility;
use Rector\Generic\Rector\Property\ChangePropertyVisibilityRector;
use Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector\Source\ParentObject;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210105\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangePropertyVisibilityRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210105\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\Property\ChangePropertyVisibilityRector::class => [\Rector\Generic\Rector\Property\ChangePropertyVisibilityRector::PROPERTY_TO_VISIBILITY_BY_CLASS => [\Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector\Source\ParentObject::class => ['toBePublicProperty' => \Rector\Core\ValueObject\Visibility::PUBLIC, 'toBeProtectedProperty' => \Rector\Core\ValueObject\Visibility::PROTECTED, 'toBePrivateProperty' => \Rector\Core\ValueObject\Visibility::PRIVATE, 'toBePublicStaticProperty' => \Rector\Core\ValueObject\Visibility::PUBLIC], 'Rector\\Generic\\Tests\\Rector\\Property\\ChangePropertyVisibilityRector\\Fixture\\Fixture3' => ['toBePublicStaticProperty' => \Rector\Core\ValueObject\Visibility::PUBLIC]]]];
    }
}
