<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection;

use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Schema\Expect;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RegistryFactory;
class RulesExtension extends \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::listOf('string');
    }
    public function loadConfiguration() : void
    {
        /** @var mixed[] $config */
        $config = $this->config;
        $builder = $this->getContainerBuilder();
        foreach ($config as $key => $rule) {
            $builder->addDefinition($this->prefix((string) $key))->setFactory($rule)->setAutowired(\false)->addTag(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RegistryFactory::RULE_TAG);
        }
    }
}
