<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Symfony\Bundle\FrameworkBundle\Test;

use _PhpScoper88fe6e0ad041\PHPUnit\Framework\TestCase;
use _PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\ContainerInterface;
if (\class_exists('_PhpScoper88fe6e0ad041\\Symfony\\Bundle\\FrameworkBundle\\Test\\KernelTestCase')) {
    return;
}
class KernelTestCase extends \_PhpScoper88fe6e0ad041\PHPUnit\Framework\TestCase
{
    /**
     * @var ContainerInterface
     */
    protected static $container;
}
