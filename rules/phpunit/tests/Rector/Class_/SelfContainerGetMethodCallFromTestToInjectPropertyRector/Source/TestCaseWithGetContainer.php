<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
