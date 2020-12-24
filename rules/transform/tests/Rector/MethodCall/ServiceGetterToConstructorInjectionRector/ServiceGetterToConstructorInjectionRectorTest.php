<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector;
use _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector\Source\AnotherService;
use _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector\Source\FirstService;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ServiceGetterToConstructorInjectionRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
    protected function getPhpVersion() : int
    {
        return \_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES - 1;
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::class => [\_PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector::METHOD_CALL_TO_SERVICES => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection(\_PhpScopere8e811afab72\Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector\Source\FirstService::class, 'getAnotherService', \_PhpScopere8e811afab72\Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector\Source\AnotherService::class)]]];
    }
}
