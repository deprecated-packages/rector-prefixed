<?php

declare (strict_types=1);
namespace PHPStan\DependencyInjection;

use _PhpScoperabd03f0baf05\Nette\Schema\Expect;
use PHPStan\Rules\RegistryFactory;
class RulesExtension extends \_PhpScoperabd03f0baf05\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_PhpScoperabd03f0baf05\Nette\Schema\Schema
    {
        return \_PhpScoperabd03f0baf05\Nette\Schema\Expect::listOf('string');
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
