<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210503\Symfony\Component\DependencyInjection\Config;

use RectorPrefix20210503\Symfony\Component\Config\Resource\ResourceInterface;
use RectorPrefix20210503\Symfony\Component\Config\ResourceCheckerInterface;
use RectorPrefix20210503\Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * @author Maxime Steinhausser <maxime.steinhausser@gmail.com>
 */
class ContainerParametersResourceChecker implements \RectorPrefix20210503\Symfony\Component\Config\ResourceCheckerInterface
{
    /** @var ContainerInterface */
    private $container;
    public function __construct(\RectorPrefix20210503\Symfony\Component\DependencyInjection\ContainerInterface $container)
    {
        $this->container = $container;
    }
    /**
     * {@inheritdoc}
     */
    public function supports(\RectorPrefix20210503\Symfony\Component\Config\Resource\ResourceInterface $metadata)
    {
        return $metadata instanceof \RectorPrefix20210503\Symfony\Component\DependencyInjection\Config\ContainerParametersResource;
    }
    /**
     * {@inheritdoc}
     */
    public function isFresh(\RectorPrefix20210503\Symfony\Component\Config\Resource\ResourceInterface $resource, int $timestamp)
    {
        foreach ($resource->getParameters() as $key => $value) {
            if (!$this->container->hasParameter($key) || $this->container->getParameter($key) !== $value) {
                return \false;
            }
        }
        return \true;
    }
}
