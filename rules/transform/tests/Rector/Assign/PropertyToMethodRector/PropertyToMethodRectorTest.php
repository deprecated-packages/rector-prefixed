<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Rector\Transform\Rector\Assign\PropertyToMethodRector;
use _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector\Source\Translator;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyToMethodRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\Assign\PropertyToMethodRector::class => [\_PhpScoperb75b35f52b74\Rector\Transform\Rector\Assign\PropertyToMethodRector::PROPERTIES_TO_METHOD_CALLS => [new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod(\_PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector\Source\Translator::class, 'locale', 'getLocale', 'setLocale'), new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod('_PhpScoperb75b35f52b74\\Rector\\Transform\\Tests\\Rector\\Assign\\PropertyToMethodRector\\Fixture\\Fixture2', 'parameter', 'getConfig', null, ['parameter'])]]];
    }
}
