<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Property\InjectAnnotationClassRector;

use _PhpScoper0a6b37af0871\DI\Annotation\Inject as PHPDIInject;
use Iterator;
use _PhpScoper0a6b37af0871\JMS\DiExtraBundle\Annotation\Inject;
use _PhpScoper0a6b37af0871\Rector\Core\Configuration\Option;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\Property\InjectAnnotationClassRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class InjectAnnotationClassRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScoper0a6b37af0871\Rector\Core\Configuration\Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER, __DIR__ . '/../../../../../symfony/tests/Rector/MethodCall/GetToConstructorInjectionRector/xml/services.xml');
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Property\InjectAnnotationClassRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Property\InjectAnnotationClassRector::ANNOTATION_CLASSES => [\_PhpScoper0a6b37af0871\JMS\DiExtraBundle\Annotation\Inject::class, \_PhpScoper0a6b37af0871\DI\Annotation\Inject::class]]];
    }
}
