<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Rector\Transform\Rector\Assign\PropertyToMethodRector;
use _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector\Source\Translator;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyToMethodRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Transform\Rector\Assign\PropertyToMethodRector::class => [\_PhpScopere8e811afab72\Rector\Transform\Rector\Assign\PropertyToMethodRector::PROPERTIES_TO_METHOD_CALLS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod(\_PhpScopere8e811afab72\Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector\Source\Translator::class, 'locale', 'getLocale', 'setLocale'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod('_PhpScopere8e811afab72\\Rector\\Transform\\Tests\\Rector\\Assign\\PropertyToMethodRector\\Fixture\\Fixture2', 'parameter', 'getConfig', null, ['parameter'])]]];
    }
}
