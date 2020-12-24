<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules;

use _PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Container;
class RegistryFactory
{
    public const RULE_TAG = 'phpstan.rules.rule';
    /** @var Container */
    private $container;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function create() : \_PhpScoper0a6b37af0871\PHPStan\Rules\Registry
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Rules\Registry($this->container->getServicesByTag(self::RULE_TAG));
    }
}
