<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoper8b9c402c5f32\PHPUnit\Framework\TestCase;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoper8b9c402c5f32\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
