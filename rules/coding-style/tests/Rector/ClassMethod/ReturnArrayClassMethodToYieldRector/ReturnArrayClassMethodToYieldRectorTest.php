<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;

use Iterator;
use RectorPrefix20201230\PHPUnit\Framework\TestCase;
use Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\EventSubscriberInterface;
use Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\ParentTestCase;
use Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo;
final class ReturnArrayClassMethodToYieldRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class => [\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::METHODS_TO_YIELDS => [new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\EventSubscriberInterface::class, 'getSubscribedEvents'), new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\ParentTestCase::class, 'provide*'), new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\ParentTestCase::class, 'dataProvider*'), new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\RectorPrefix20201230\PHPUnit\Framework\TestCase::class, 'provideData')]]];
    }
}
