<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoperf18a0c41e2d2\PHPUnit\Framework\TestCase;
use _PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoperf18a0c41e2d2\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
