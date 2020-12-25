<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoper50d83356d739\PHPUnit\Framework\TestCase;
use _PhpScoper50d83356d739\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoper50d83356d739\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoper50d83356d739\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
