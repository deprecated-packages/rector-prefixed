<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210317\Symfony\Component\DependencyInjection\Dumper;

use RectorPrefix20210317\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * Dumper is the abstract class for all built-in dumpers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class Dumper implements \RectorPrefix20210317\Symfony\Component\DependencyInjection\Dumper\DumperInterface
{
    protected $container;
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }
}
