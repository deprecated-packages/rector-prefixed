<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules;

use _PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Container;
class RegistryFactory
{
    public const RULE_TAG = 'phpstan.rules.rule';
    /** @var Container */
    private $container;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function create() : \_PhpScoper0a2ac50786fa\PHPStan\Rules\Registry
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Registry($this->container->getServicesByTag(self::RULE_TAG));
    }
}
