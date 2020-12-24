<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\SymfonyCodeQuality\Tests\Rector\Class_\EventListenerToEventSubscriberRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\SymfonyCodeQuality\Rector\Class_\EventListenerToEventSubscriberRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class EventListenerToEventSubscriberRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        // wtf: all test have to be in single file due to autoloading race-condigition and container creating issue of fixture
        $this->setParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER, __DIR__ . '/config/listener_services.xml');
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\SymfonyCodeQuality\Rector\Class_\EventListenerToEventSubscriberRector::class;
    }
}
