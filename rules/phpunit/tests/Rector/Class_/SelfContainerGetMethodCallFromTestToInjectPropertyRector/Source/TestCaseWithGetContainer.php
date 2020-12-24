<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoper2a4e7ab1ecbc\PHPUnit\Framework\TestCase;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoper2a4e7ab1ecbc\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
