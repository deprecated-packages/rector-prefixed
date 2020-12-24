<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules;

use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Container;
class RegistryFactory
{
    public const RULE_TAG = 'phpstan.rules.rule';
    /** @var Container */
    private $container;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function create() : \_PhpScopere8e811afab72\PHPStan\Rules\Registry
    {
        return new \_PhpScopere8e811afab72\PHPStan\Rules\Registry($this->container->getServicesByTag(self::RULE_TAG));
    }
}
