<?php

declare (strict_types=1);
namespace Rector\SymfonyCodeQuality\Tests\Rector\Class_\EventListenerToEventSubscriberRector;

use Iterator;
use Rector\Core\Configuration\Option;
use Rector\SymfonyCodeQuality\Rector\Class_\EventListenerToEventSubscriberRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo;
final class EventListenerToEventSubscriberRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        // wtf: all test have to be in single file due to autoloading race-condigition and container creating issue of fixture
        $this->setParameter(\Rector\Core\Configuration\Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER, __DIR__ . '/config/listener_services.xml');
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\SymfonyCodeQuality\Rector\Class_\EventListenerToEventSubscriberRector::class;
    }
}
