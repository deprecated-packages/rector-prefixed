<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Symfony\Bundle\FrameworkBundle\Test;

use _PhpScoper26e51eeacccf\PHPUnit\Framework\TestCase;
use _PhpScoper26e51eeacccf\Symfony\Component\DependencyInjection\ContainerInterface;
if (\class_exists('_PhpScoper26e51eeacccf\\Symfony\\Bundle\\FrameworkBundle\\Test\\KernelTestCase')) {
    return;
}
class KernelTestCase extends \_PhpScoper26e51eeacccf\PHPUnit\Framework\TestCase
{
    /**
     * @var ContainerInterface
     */
    protected static $container;
}
