<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\DependencyInjection;

use _PhpScoperbf340cb0be9d\Psr\Container\ContainerInterface;
use _PhpScoperbf340cb0be9d\Symfony\Component\HttpFoundation\RequestStack;
use _PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\Fragment\FragmentHandler;
/**
 * Lazily loads fragment renderers from the dependency injection container.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class LazyLoadingFragmentHandler extends \_PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\Fragment\FragmentHandler
{
    private $container;
    private $initialized = [];
    public function __construct(\_PhpScoperbf340cb0be9d\Psr\Container\ContainerInterface $container, \_PhpScoperbf340cb0be9d\Symfony\Component\HttpFoundation\RequestStack $requestStack, bool $debug = \false)
    {
        $this->container = $container;
        parent::__construct($requestStack, [], $debug);
    }
    /**
     * {@inheritdoc}
     */
    public function render($uri, string $renderer = 'inline', array $options = [])
    {
        if (!isset($this->initialized[$renderer]) && $this->container->has($renderer)) {
            $this->addRenderer($this->container->get($renderer));
            $this->initialized[$renderer] = \true;
        }
        return parent::render($uri, $renderer, $options);
    }
}
