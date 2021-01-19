<?php

declare (strict_types=1);
namespace Rector\Symfony\Tests\Rector\MethodCall\GetToConstructorInjectionRector;

use Iterator;
use Rector\Core\Configuration\Option;
use Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector;
use Rector\Symfony\Tests\Rector\MethodCall\GetToConstructorInjectionRector\Source\GetTrait;
use Rector\Symfony\Tests\Rector\Source\SymfonyController;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210119\Symplify\SmartFileSystem\SmartFileInfo;
final class GetToConstructorInjectionRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210119\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\Rector\Core\Configuration\Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER, __DIR__ . '/xml/services.xml');
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
        return [\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::class => [\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::GET_METHOD_AWARE_TYPES => [\Rector\Symfony\Tests\Rector\Source\SymfonyController::class, \Rector\Symfony\Tests\Rector\MethodCall\GetToConstructorInjectionRector\Source\GetTrait::class]]];
    }
}
