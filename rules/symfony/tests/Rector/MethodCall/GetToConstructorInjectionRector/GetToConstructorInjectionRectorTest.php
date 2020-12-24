<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Symfony\Tests\Rector\MethodCall\GetToConstructorInjectionRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Core\Configuration\Option;
use _PhpScoper0a6b37af0871\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector;
use _PhpScoper0a6b37af0871\Rector\Symfony\Tests\Rector\MethodCall\GetToConstructorInjectionRector\Source\GetTrait;
use _PhpScoper0a6b37af0871\Rector\Symfony\Tests\Rector\Source\SymfonyController;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class GetToConstructorInjectionRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScoper0a6b37af0871\Rector\Core\Configuration\Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER, __DIR__ . '/xml/services.xml');
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
        return [\_PhpScoper0a6b37af0871\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::class => [\_PhpScoper0a6b37af0871\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::GET_METHOD_AWARE_TYPES => [\_PhpScoper0a6b37af0871\Rector\Symfony\Tests\Rector\Source\SymfonyController::class, \_PhpScoper0a6b37af0871\Rector\Symfony\Tests\Rector\MethodCall\GetToConstructorInjectionRector\Source\GetTrait::class]]];
    }
}
