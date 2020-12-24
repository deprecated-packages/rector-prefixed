<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony\Tests\Rector\MethodCall\GetToConstructorInjectionRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector;
use _PhpScopere8e811afab72\Rector\Symfony\Tests\Rector\MethodCall\GetToConstructorInjectionRector\Source\GetTrait;
use _PhpScopere8e811afab72\Rector\Symfony\Tests\Rector\Source\SymfonyController;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class GetToConstructorInjectionRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::class => [\_PhpScopere8e811afab72\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::GET_METHOD_AWARE_TYPES => [\_PhpScopere8e811afab72\Rector\Symfony\Tests\Rector\Source\SymfonyController::class, \_PhpScopere8e811afab72\Rector\Symfony\Tests\Rector\MethodCall\GetToConstructorInjectionRector\Source\GetTrait::class]]];
    }
}
