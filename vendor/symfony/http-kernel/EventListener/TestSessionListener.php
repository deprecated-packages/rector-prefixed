<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopere8e811afab72\Symfony\Component\HttpKernel\EventListener;

use _PhpScopere8e811afab72\Psr\Container\ContainerInterface;
use _PhpScopere8e811afab72\Symfony\Component\HttpFoundation\Session\SessionInterface;
/**
 * Sets the session in the request.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class TestSessionListener extends \_PhpScopere8e811afab72\Symfony\Component\HttpKernel\EventListener\AbstractTestSessionListener
{
    private $container;
    public function __construct(\_PhpScopere8e811afab72\Psr\Container\ContainerInterface $container, array $sessionOptions = [])
    {
        $this->container = $container;
        parent::__construct($sessionOptions);
    }
    protected function getSession() : ?\_PhpScopere8e811afab72\Symfony\Component\HttpFoundation\Session\SessionInterface
    {
        if (!$this->container->has('session')) {
            return null;
        }
        return $this->container->get('session');
    }
}
