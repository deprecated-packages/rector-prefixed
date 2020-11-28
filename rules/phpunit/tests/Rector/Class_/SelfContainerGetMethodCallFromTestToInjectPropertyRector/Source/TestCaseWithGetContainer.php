<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase;
use _PhpScoperabd03f0baf05\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoperabd03f0baf05\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
