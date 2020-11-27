<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScopera143bcca66cb\PHPUnit\Framework\TestCase;
use _PhpScopera143bcca66cb\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScopera143bcca66cb\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScopera143bcca66cb\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
