<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Symfony\Bundle\FrameworkBundle\Test;

use _PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase;
use _PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\ContainerInterface;
if (\class_exists('_PhpScoperbd5d0c5f7638\\Symfony\\Bundle\\FrameworkBundle\\Test\\KernelTestCase')) {
    return;
}
class KernelTestCase extends \_PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase
{
    /**
     * @var ContainerInterface
     */
    protected static $container;
}
