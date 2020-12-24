<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\Property\ChangePropertyVisibilityRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector\Source\ParentObject;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangePropertyVisibilityRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Property\ChangePropertyVisibilityRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Property\ChangePropertyVisibilityRector::PROPERTY_TO_VISIBILITY_BY_CLASS => [\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector\Source\ParentObject::class => ['toBePublicProperty' => 'public', 'toBeProtectedProperty' => 'protected', 'toBePrivateProperty' => 'private', 'toBePublicStaticProperty' => 'public'], '_PhpScoperb75b35f52b74\\Rector\\Generic\\Tests\\Rector\\Property\\ChangePropertyVisibilityRector\\Fixture\\Fixture3' => ['toBePublicStaticProperty' => 'public']]]];
    }
}
