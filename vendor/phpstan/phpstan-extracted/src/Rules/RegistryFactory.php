<?php

declare (strict_types=1);
namespace PHPStan\Rules;

use PHPStan\DependencyInjection\Container;
class RegistryFactory
{
    public const RULE_TAG = 'phpstan.rules.rule';
    /** @var Container */
    private $container;
    public function __construct(\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function create() : \PHPStan\Rules\Registry
    {
        return new \PHPStan\Rules\Registry($this->container->getServicesByTag(self::RULE_TAG));
    }
}
