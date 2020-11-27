<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase;
use _PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
