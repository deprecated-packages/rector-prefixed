<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoper17db12703726\PHPUnit\Framework\TestCase;
use _PhpScoper17db12703726\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoper17db12703726\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoper17db12703726\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
