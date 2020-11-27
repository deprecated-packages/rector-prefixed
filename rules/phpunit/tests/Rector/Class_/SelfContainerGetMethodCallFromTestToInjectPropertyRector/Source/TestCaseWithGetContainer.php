<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoper26e51eeacccf\PHPUnit\Framework\TestCase;
use _PhpScoper26e51eeacccf\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoper26e51eeacccf\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoper26e51eeacccf\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
