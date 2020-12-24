<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoper0a6b37af0871\PHPUnit\Framework\TestCase;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoper0a6b37af0871\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
