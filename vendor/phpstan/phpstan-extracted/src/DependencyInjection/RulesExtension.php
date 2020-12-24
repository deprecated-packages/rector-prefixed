<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\DependencyInjection;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Expect;
use _PhpScopere8e811afab72\PHPStan\Rules\RegistryFactory;
class RulesExtension extends \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::listOf('string');
    }
    public function loadConfiguration() : void
    {
        /** @var mixed[] $config */
        $config = $this->config;
        $builder = $this->getContainerBuilder();
        foreach ($config as $key => $rule) {
            $builder->addDefinition($this->prefix((string) $key))->setFactory($rule)->setAutowired(\false)->addTag(\_PhpScopere8e811afab72\PHPStan\Rules\RegistryFactory::RULE_TAG);
        }
    }
}
