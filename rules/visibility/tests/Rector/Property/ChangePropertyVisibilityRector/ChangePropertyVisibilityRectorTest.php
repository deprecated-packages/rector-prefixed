<?php

declare (strict_types=1);
namespace Rector\Visibility\Tests\Rector\Property\ChangePropertyVisibilityRector;

use Iterator;
use Rector\Core\ValueObject\Visibility;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Visibility\Rector\Property\ChangePropertyVisibilityRector;
use Rector\Visibility\Tests\Rector\Property\ChangePropertyVisibilityRector\Source\ParentObject;
use RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangePropertyVisibilityRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\Rector\Visibility\Rector\Property\ChangePropertyVisibilityRector::class => [\Rector\Visibility\Rector\Property\ChangePropertyVisibilityRector::PROPERTY_TO_VISIBILITY_BY_CLASS => [\Rector\Visibility\Tests\Rector\Property\ChangePropertyVisibilityRector\Source\ParentObject::class => ['toBePublicProperty' => \Rector\Core\ValueObject\Visibility::PUBLIC, 'toBeProtectedProperty' => \Rector\Core\ValueObject\Visibility::PROTECTED, 'toBePrivateProperty' => \Rector\Core\ValueObject\Visibility::PRIVATE, 'toBePublicStaticProperty' => \Rector\Core\ValueObject\Visibility::PUBLIC], 'Rector\\Visibility\\Tests\\Rector\\Property\\ChangePropertyVisibilityRector\\Fixture\\Fixture3' => ['toBePublicStaticProperty' => \Rector\Core\ValueObject\Visibility::PUBLIC]]]];
    }
}
