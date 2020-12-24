<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules;

use _PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Container;
class RegistryFactory
{
    public const RULE_TAG = 'phpstan.rules.rule';
    /** @var Container */
    private $container;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function create() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Registry
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Registry($this->container->getServicesByTag(self::RULE_TAG));
    }
}
