<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoper567b66d83109\PHPUnit\Framework\TestCase;
use _PhpScoper567b66d83109\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoper567b66d83109\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
