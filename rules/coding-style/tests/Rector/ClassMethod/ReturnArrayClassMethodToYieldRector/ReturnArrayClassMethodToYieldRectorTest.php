<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;

use Iterator;
use _PhpScoper0a6b37af0871\PHPUnit\Framework\TestCase;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\EventSubscriberInterface;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\ParentTestCase;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ReturnArrayClassMethodToYieldRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class => [\_PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::METHODS_TO_YIELDS => [new \_PhpScoper0a6b37af0871\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\_PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\EventSubscriberInterface::class, 'getSubscribedEvents'), new \_PhpScoper0a6b37af0871\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\_PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\ParentTestCase::class, 'provide*'), new \_PhpScoper0a6b37af0871\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\_PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\ParentTestCase::class, 'dataProvider*'), new \_PhpScoper0a6b37af0871\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\_PhpScoper0a6b37af0871\PHPUnit\Framework\TestCase::class, 'provideData')]]];
    }
}
