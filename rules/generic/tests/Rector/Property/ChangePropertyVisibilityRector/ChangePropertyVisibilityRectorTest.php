<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector;

use Iterator;
use Rector\Generic\Rector\Property\ChangePropertyVisibilityRector;
use Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector\Source\ParentObject;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class ChangePropertyVisibilityRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\Property\ChangePropertyVisibilityRector::class => [\Rector\Generic\Rector\Property\ChangePropertyVisibilityRector::PROPERTY_TO_VISIBILITY_BY_CLASS => [\Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector\Source\ParentObject::class => ['toBePublicProperty' => 'public', 'toBeProtectedProperty' => 'protected', 'toBePrivateProperty' => 'private', 'toBePublicStaticProperty' => 'public'], 'Rector\\Generic\\Tests\\Rector\\Property\\ChangePropertyVisibilityRector\\Fixture\\NormalObject' => ['toBePublicStaticProperty' => 'public']]]];
    }
}
