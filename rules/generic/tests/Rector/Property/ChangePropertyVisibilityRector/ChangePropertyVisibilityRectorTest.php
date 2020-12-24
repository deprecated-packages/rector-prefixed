<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\Property\ChangePropertyVisibilityRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector\Source\ParentObject;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangePropertyVisibilityRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Property\ChangePropertyVisibilityRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Property\ChangePropertyVisibilityRector::PROPERTY_TO_VISIBILITY_BY_CLASS => [\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector\Source\ParentObject::class => ['toBePublicProperty' => 'public', 'toBeProtectedProperty' => 'protected', 'toBePrivateProperty' => 'private', 'toBePublicStaticProperty' => 'public'], '_PhpScoper0a6b37af0871\\Rector\\Generic\\Tests\\Rector\\Property\\ChangePropertyVisibilityRector\\Fixture\\Fixture3' => ['toBePublicStaticProperty' => 'public']]]];
    }
}
