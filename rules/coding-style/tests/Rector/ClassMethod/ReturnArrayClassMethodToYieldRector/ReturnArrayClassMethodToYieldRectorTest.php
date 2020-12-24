<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;

use Iterator;
use _PhpScopere8e811afab72\PHPUnit\Framework\TestCase;
use _PhpScopere8e811afab72\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\EventSubscriberInterface;
use _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\ParentTestCase;
use _PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ReturnArrayClassMethodToYieldRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class => [\_PhpScopere8e811afab72\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::METHODS_TO_YIELDS => [new \_PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\_PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\EventSubscriberInterface::class, 'getSubscribedEvents'), new \_PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\_PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\ParentTestCase::class, 'provide*'), new \_PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\_PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\ParentTestCase::class, 'dataProvider*'), new \_PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\_PhpScopere8e811afab72\PHPUnit\Framework\TestCase::class, 'provideData')]]];
    }
}
