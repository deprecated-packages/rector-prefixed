<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector;
use _PhpScopere8e811afab72\Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source\ContainerAwareParentClass;
use _PhpScopere8e811afab72\Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source\ContainerAwareParentCommand;
use _PhpScopere8e811afab72\Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source\ThisClassCallsMethodInConstructor;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ContainerGetToConstructorInjectionRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER, __DIR__ . '/xml/services.xml');
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
        return [\_PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector::class => [\_PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector::CONTAINER_AWARE_PARENT_TYPES => [\_PhpScopere8e811afab72\Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source\ContainerAwareParentClass::class, \_PhpScopere8e811afab72\Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source\ContainerAwareParentCommand::class, \_PhpScopere8e811afab72\Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source\ThisClassCallsMethodInConstructor::class]]];
    }
}
