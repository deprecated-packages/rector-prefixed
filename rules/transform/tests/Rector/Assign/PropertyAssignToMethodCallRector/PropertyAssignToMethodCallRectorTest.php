<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\Assign\PropertyAssignToMethodCallRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Rector\Transform\Rector\Assign\PropertyAssignToMethodCallRector;
use _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\Assign\PropertyAssignToMethodCallRector\Source\ChoiceControl;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\PropertyAssignToMethodCall;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyAssignToMethodCallRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\Assign\PropertyAssignToMethodCallRector::class => [\_PhpScoper0a6b37af0871\Rector\Transform\Rector\Assign\PropertyAssignToMethodCallRector::PROPERTY_ASSIGNS_TO_METHODS_CALLS => [new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\PropertyAssignToMethodCall(\_PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\Assign\PropertyAssignToMethodCallRector\Source\ChoiceControl::class, 'checkAllowedValues', 'checkDefaultValue')]]];
    }
}
