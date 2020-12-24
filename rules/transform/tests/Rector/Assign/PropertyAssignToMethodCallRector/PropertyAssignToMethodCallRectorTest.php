<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\Assign\PropertyAssignToMethodCallRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Rector\Transform\Rector\Assign\PropertyAssignToMethodCallRector;
use _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\Assign\PropertyAssignToMethodCallRector\Source\ChoiceControl;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyAssignToMethodCall;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyAssignToMethodCallRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\Assign\PropertyAssignToMethodCallRector::class => [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\Assign\PropertyAssignToMethodCallRector::PROPERTY_ASSIGNS_TO_METHODS_CALLS => [new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyAssignToMethodCall(\_PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\Assign\PropertyAssignToMethodCallRector\Source\ChoiceControl::class, 'checkAllowedValues', 'checkDefaultValue')]]];
    }
}
