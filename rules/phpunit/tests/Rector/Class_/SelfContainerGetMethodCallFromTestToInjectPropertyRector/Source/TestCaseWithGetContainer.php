<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoper5edc98a7cce2\PHPUnit\Framework\TestCase;
use _PhpScoper5edc98a7cce2\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoper5edc98a7cce2\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoper5edc98a7cce2\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
