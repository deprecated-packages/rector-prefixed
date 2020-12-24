<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules;

use _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container;
class RegistryFactory
{
    public const RULE_TAG = 'phpstan.rules.rule';
    /** @var Container */
    private $container;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function create() : \_PhpScoperb75b35f52b74\PHPStan\Rules\Registry
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Rules\Registry($this->container->getServicesByTag(self::RULE_TAG));
    }
}
