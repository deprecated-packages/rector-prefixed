<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader;

use RectorPrefix2020DecSat\Symfony\Component\Config\Loader\Loader;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * ClosureLoader loads service definitions from a PHP closure.
 *
 * The Closure has access to the container as its first argument.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ClosureLoader extends \RectorPrefix2020DecSat\Symfony\Component\Config\Loader\Loader
{
    private $container;
    public function __construct(\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $this->container = $container;
    }
    /**
     * {@inheritdoc}
     */
    public function load($resource, string $type = null)
    {
        $resource($this->container);
    }
    /**
     * {@inheritdoc}
     */
    public function supports($resource, string $type = null)
    {
        return $resource instanceof \Closure;
    }
}
