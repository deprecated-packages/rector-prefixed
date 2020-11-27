<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Symfony\Bundle\FrameworkBundle\Test;

use _PhpScoper006a73f0e455\PHPUnit\Framework\TestCase;
use _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ContainerInterface;
if (\class_exists('_PhpScoper006a73f0e455\\Symfony\\Bundle\\FrameworkBundle\\Test\\KernelTestCase')) {
    return;
}
class KernelTestCase extends \_PhpScoper006a73f0e455\PHPUnit\Framework\TestCase
{
    /**
     * @var ContainerInterface
     */
    protected static $container;
}
