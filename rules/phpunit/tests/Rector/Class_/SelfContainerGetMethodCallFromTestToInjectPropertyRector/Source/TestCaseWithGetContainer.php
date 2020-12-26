<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use RectorPrefix2020DecSat\PHPUnit\Framework\TestCase;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \RectorPrefix2020DecSat\PHPUnit\Framework\TestCase
{
    public function getContainer() : \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
