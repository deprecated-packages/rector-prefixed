<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoper006a73f0e455\PHPUnit\Framework\TestCase;
use _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoper006a73f0e455\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
