<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\DependencyInjection;

use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Schema\Expect;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RegistryFactory;
class RulesExtension extends \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::listOf('string');
    }
    public function loadConfiguration() : void
    {
        /** @var mixed[] $config */
        $config = $this->config;
        $builder = $this->getContainerBuilder();
        foreach ($config as $key => $rule) {
            $builder->addDefinition($this->prefix((string) $key))->setFactory($rule)->setAutowired(\false)->addTag(\_PhpScoper0a2ac50786fa\PHPStan\Rules\RegistryFactory::RULE_TAG);
        }
    }
}
