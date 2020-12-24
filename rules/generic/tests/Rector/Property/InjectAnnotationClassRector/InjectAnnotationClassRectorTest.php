<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Property\InjectAnnotationClassRector;

use _PhpScopere8e811afab72\DI\Annotation\Inject as PHPDIInject;
use Iterator;
use _PhpScopere8e811afab72\JMS\DiExtraBundle\Annotation\Inject;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\Generic\Rector\Property\InjectAnnotationClassRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class InjectAnnotationClassRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER, __DIR__ . '/../../../../../symfony/tests/Rector/MethodCall/GetToConstructorInjectionRector/xml/services.xml');
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\Property\InjectAnnotationClassRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\Property\InjectAnnotationClassRector::ANNOTATION_CLASSES => [\_PhpScopere8e811afab72\JMS\DiExtraBundle\Annotation\Inject::class, \_PhpScopere8e811afab72\DI\Annotation\Inject::class]]];
    }
}
