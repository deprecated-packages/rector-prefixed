<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\Assign\PropertyToMethodRector;
use Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector\Source\Translator;
use Rector\Transform\ValueObject\PropertyToMethod;
use RectorPrefix20201227\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyToMethodRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201227\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\Assign\PropertyToMethodRector::class => [\Rector\Transform\Rector\Assign\PropertyToMethodRector::PROPERTIES_TO_METHOD_CALLS => [new \Rector\Transform\ValueObject\PropertyToMethod(\Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector\Source\Translator::class, 'locale', 'getLocale', 'setLocale'), new \Rector\Transform\ValueObject\PropertyToMethod('Rector\\Transform\\Tests\\Rector\\Assign\\PropertyToMethodRector\\Fixture\\Fixture2', 'parameter', 'getConfig', null, ['parameter'])]]];
    }
}
