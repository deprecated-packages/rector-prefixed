<?php

declare (strict_types=1);
namespace PHPStan\DependencyInjection;

use _PhpScopera143bcca66cb\Nette\Schema\Expect;
use PHPStan\Rules\RegistryFactory;
class RulesExtension extends \_PhpScopera143bcca66cb\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_PhpScopera143bcca66cb\Nette\Schema\Schema
    {
        return \_PhpScopera143bcca66cb\Nette\Schema\Expect::listOf('string');
    }
    public function loadConfiguration() : void
    {
        /** @var mixed[] $config */
        $config = $this->config;
        $builder = $this->getContainerBuilder();
        foreach ($config as $key => $rule) {
            $builder->addDefinition($this->prefix((string) $key))->setFactory($rule)->setAutowired(\false)->addTag(\PHPStan\Rules\RegistryFactory::RULE_TAG);
        }
    }
}
