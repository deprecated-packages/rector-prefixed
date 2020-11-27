<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Symfony\Bundle\FrameworkBundle\Test;

use _PhpScopera143bcca66cb\PHPUnit\Framework\TestCase;
use _PhpScopera143bcca66cb\Symfony\Component\DependencyInjection\ContainerInterface;
if (\class_exists('_PhpScopera143bcca66cb\\Symfony\\Bundle\\FrameworkBundle\\Test\\KernelTestCase')) {
    return;
}
class KernelTestCase extends \_PhpScopera143bcca66cb\PHPUnit\Framework\TestCase
{
    /**
     * @var ContainerInterface
     */
    protected static $container;
}
