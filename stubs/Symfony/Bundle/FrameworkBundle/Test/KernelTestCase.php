<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Symfony\Bundle\FrameworkBundle\Test;

use _PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase;
use _PhpScoperabd03f0baf05\Symfony\Component\DependencyInjection\ContainerInterface;
if (\class_exists('_PhpScoperabd03f0baf05\\Symfony\\Bundle\\FrameworkBundle\\Test\\KernelTestCase')) {
    return;
}
class KernelTestCase extends \_PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase
{
    /**
     * @var ContainerInterface
     */
    protected static $container;
}
