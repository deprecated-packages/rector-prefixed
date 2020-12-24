<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;

use Iterator;
use _PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\EventSubscriberInterface;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\ParentTestCase;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ReturnArrayClassMethodToYieldRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class => [\_PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::METHODS_TO_YIELDS => [new \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\_PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\EventSubscriberInterface::class, 'getSubscribedEvents'), new \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\_PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\ParentTestCase::class, 'provide*'), new \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\_PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\ParentTestCase::class, 'dataProvider*'), new \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\_PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase::class, 'provideData')]]];
    }
}
