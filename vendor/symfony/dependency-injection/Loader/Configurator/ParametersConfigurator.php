<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator;

use RectorPrefix20210408\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ParametersConfigurator extends \RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractConfigurator
{
    public const FACTORY = 'parameters';
    private $container;
    public function __construct(\RectorPrefix20210408\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $this->container = $container;
    }
    /**
     * Creates a parameter.
     *
     * @return $this
     */
    public final function set(string $name, $value)
    {
        $this->container->setParameter($name, static::processValue($value, \true));
        return $this;
    }
    /**
     * Creates a parameter.
     *
     * @return $this
     */
    public final function __invoke(string $name, $value)
    {
        return $this->set($name, $value);
    }
}
