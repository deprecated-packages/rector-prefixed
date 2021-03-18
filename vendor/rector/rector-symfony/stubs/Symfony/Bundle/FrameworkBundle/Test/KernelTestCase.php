<?php

declare (strict_types=1);
namespace RectorPrefix20210318\Symfony\Bundle\FrameworkBundle\Test;

use RectorPrefix20210318\PHPUnit\Framework\TestCase;
use RectorPrefix20210318\Symfony\Component\DependencyInjection\ContainerInterface;
if (\class_exists('RectorPrefix20210318\\Symfony\\Bundle\\FrameworkBundle\\Test\\KernelTestCase')) {
    return;
}
class KernelTestCase extends \RectorPrefix20210318\PHPUnit\Framework\TestCase
{
    /**
     * @var ContainerInterface
     */
    protected static $container;
}
