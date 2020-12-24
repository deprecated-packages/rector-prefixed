<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\Property\ChangePropertyVisibilityRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector\Source\ParentObject;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangePropertyVisibilityRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\Property\ChangePropertyVisibilityRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\Property\ChangePropertyVisibilityRector::PROPERTY_TO_VISIBILITY_BY_CLASS => [\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector\Source\ParentObject::class => ['toBePublicProperty' => 'public', 'toBeProtectedProperty' => 'protected', 'toBePrivateProperty' => 'private', 'toBePublicStaticProperty' => 'public'], '_PhpScopere8e811afab72\\Rector\\Generic\\Tests\\Rector\\Property\\ChangePropertyVisibilityRector\\Fixture\\Fixture3' => ['toBePublicStaticProperty' => 'public']]]];
    }
}
