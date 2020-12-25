<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoperbf340cb0be9d\PHPUnit\Framework\TestCase;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoperbf340cb0be9d\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
