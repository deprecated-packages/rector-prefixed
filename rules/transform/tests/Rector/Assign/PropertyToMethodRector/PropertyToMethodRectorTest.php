<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Rector\Transform\Rector\Assign\PropertyToMethodRector;
use _PhpScoper0a2ac50786fa\Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector\Source\Translator;
use _PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\PropertyToMethod;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyToMethodRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a2ac50786fa\Rector\Transform\Rector\Assign\PropertyToMethodRector::class => [\_PhpScoper0a2ac50786fa\Rector\Transform\Rector\Assign\PropertyToMethodRector::PROPERTIES_TO_METHOD_CALLS => [new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\PropertyToMethod(\_PhpScoper0a2ac50786fa\Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector\Source\Translator::class, 'locale', 'getLocale', 'setLocale'), new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoper0a2ac50786fa\\Rector\\Transform\\Tests\\Rector\\Assign\\PropertyToMethodRector\\Fixture\\Fixture2', 'parameter', 'getConfig', null, ['parameter'])]]];
    }
}
