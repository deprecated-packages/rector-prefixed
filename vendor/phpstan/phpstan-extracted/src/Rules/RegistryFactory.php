<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules;

use RectorPrefix20201227\PHPStan\DependencyInjection\Container;
class RegistryFactory
{
    public const RULE_TAG = 'phpstan.rules.rule';
    /** @var Container */
    private $container;
    public function __construct(\RectorPrefix20201227\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function create() : \RectorPrefix20201227\PHPStan\Rules\Registry
    {
        return new \RectorPrefix20201227\PHPStan\Rules\Registry($this->container->getServicesByTag(self::RULE_TAG));
    }
}
