<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\Assign\PropertyFetchToMethodCallRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\Assign\PropertyFetchToMethodCallRector;
use Rector\Transform\Tests\Rector\Assign\PropertyFetchToMethodCallRector\Source\Translator;
use Rector\Transform\ValueObject\PropertyFetchToMethodCall;
use RectorPrefix20210203\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyFetchToMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210203\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\Assign\PropertyFetchToMethodCallRector::class => [\Rector\Transform\Rector\Assign\PropertyFetchToMethodCallRector::PROPERTIES_TO_METHOD_CALLS => [new \Rector\Transform\ValueObject\PropertyFetchToMethodCall(\Rector\Transform\Tests\Rector\Assign\PropertyFetchToMethodCallRector\Source\Translator::class, 'locale', 'getLocale', 'setLocale'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Rector\\Transform\\Tests\\Rector\\Assign\\PropertyFetchToMethodCallRector\\Fixture\\Fixture2', 'parameter', 'getConfig', null, ['parameter'])]]];
    }
}
