<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoper88fe6e0ad041\PHPUnit\Framework\TestCase;
use _PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoper88fe6e0ad041\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
