<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\Assign\PropertyToMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector\Source\Translator;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\PropertyToMethod;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyToMethodRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\Assign\PropertyToMethodRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\Assign\PropertyToMethodRector::PROPERTIES_TO_METHOD_CALLS => [new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\PropertyToMethod(\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector\Source\Translator::class, 'locale', 'getLocale', 'setLocale'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper2a4e7ab1ecbc\\Rector\\Transform\\Tests\\Rector\\Assign\\PropertyToMethodRector\\Fixture\\Fixture2', 'parameter', 'getConfig', null, ['parameter'])]]];
    }
}
