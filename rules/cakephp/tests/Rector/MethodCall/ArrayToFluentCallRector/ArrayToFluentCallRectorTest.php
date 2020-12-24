<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector;
use _PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass;
use _PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\FactoryClass;
use _PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ArrayToFluentCall;
use _PhpScopere8e811afab72\Rector\CakePHP\ValueObject\FactoryMethod;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ArrayToFluentCallRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::class => [\_PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::ARRAYS_TO_FLUENT_CALLS => [new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ArrayToFluentCall(\_PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass::class, ['name' => 'setName', 'size' => 'setSize'])], \_PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::FACTORY_METHODS => [new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\FactoryMethod(\_PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\FactoryClass::class, 'buildClass', \_PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass::class, 2)]]];
    }
}
