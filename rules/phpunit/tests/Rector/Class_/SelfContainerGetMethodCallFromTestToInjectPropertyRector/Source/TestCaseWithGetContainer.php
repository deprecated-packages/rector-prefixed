<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoperfce0de0de1ce\PHPUnit\Framework\TestCase;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoperfce0de0de1ce\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
