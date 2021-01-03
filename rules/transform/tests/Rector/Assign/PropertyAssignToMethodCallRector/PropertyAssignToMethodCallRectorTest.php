<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\Assign\PropertyAssignToMethodCallRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\Assign\PropertyAssignToMethodCallRector;
use Rector\Transform\Tests\Rector\Assign\PropertyAssignToMethodCallRector\Source\ChoiceControl;
use Rector\Transform\ValueObject\PropertyAssignToMethodCall;
use RectorPrefix20210103\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyAssignToMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210103\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\Assign\PropertyAssignToMethodCallRector::class => [\Rector\Transform\Rector\Assign\PropertyAssignToMethodCallRector::PROPERTY_ASSIGNS_TO_METHODS_CALLS => [new \Rector\Transform\ValueObject\PropertyAssignToMethodCall(\Rector\Transform\Tests\Rector\Assign\PropertyAssignToMethodCallRector\Source\ChoiceControl::class, 'checkAllowedValues', 'checkDefaultValue')]]];
    }
}
