<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\Property\InjectAnnotationClassRector;

use RectorPrefix20210208\DI\Annotation\Inject as PHPDIInject;
use Iterator;
use RectorPrefix20210208\JMS\DiExtraBundle\Annotation\Inject;
use Rector\Core\Configuration\Option;
use Rector\Generic\Rector\Property\InjectAnnotationClassRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210208\Symplify\SmartFileSystem\SmartFileInfo;
final class InjectAnnotationClassRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210208\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\Rector\Core\Configuration\Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER, __DIR__ . '/../../../../../symfony/tests/Rector/MethodCall/GetToConstructorInjectionRector/xml/services.xml');
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
        return [\Rector\Generic\Rector\Property\InjectAnnotationClassRector::class => [\Rector\Generic\Rector\Property\InjectAnnotationClassRector::ANNOTATION_CLASSES => [\RectorPrefix20210208\JMS\DiExtraBundle\Annotation\Inject::class, \RectorPrefix20210208\DI\Annotation\Inject::class]]];
    }
}
