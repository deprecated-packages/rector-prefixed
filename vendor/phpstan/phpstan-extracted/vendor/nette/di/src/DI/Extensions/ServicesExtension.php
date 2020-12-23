<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Extensions;

use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Helpers;
/**
 * Service definitions loader.
 */
final class ServicesExtension extends \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\CompilerExtension
{
    use Nette\SmartObject;
    public function getConfigSchema() : \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::arrayOf(new \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Config\DefinitionSchema($this->getContainerBuilder()));
    }
    public function loadConfiguration()
    {
        $this->loadDefinitions($this->config);
    }
    /**
     * Loads list of service definitions.
     */
    public function loadDefinitions(array $config)
    {
        foreach ($config as $key => $defConfig) {
            $this->loadDefinition($this->convertKeyToName($key), $defConfig);
        }
    }
    /**
     * Loads service definition from normalized configuration.
     */
    private function loadDefinition(?string $name, \stdClass $config) : void
    {
        try {
            if ((array) $config === [\false]) {
                $this->getContainerBuilder()->removeDefinition($name);
                return;
            } elseif (!empty($config->alteration) && !$this->getContainerBuilder()->hasDefinition($name)) {
                throw new \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\InvalidConfigurationException('missing original definition for alteration.');
            }
            $def = $this->retrieveDefinition($name, $config);
            static $methods = [\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ServiceDefinition::class => 'updateServiceDefinition', \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\AccessorDefinition::class => 'updateAccessorDefinition', \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\FactoryDefinition::class => 'updateFactoryDefinition', \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\LocatorDefinition::class => 'updateLocatorDefinition', \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ImportedDefinition::class => 'updateImportedDefinition'];
            $this->{$methods[$config->defType]}($def, $config);
            $this->updateDefinition($def, $config);
        } catch (\Exception $e) {
            throw new \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\InvalidConfigurationException(($name ? "Service '{$name}': " : '') . $e->getMessage(), 0, $e);
        }
    }
    /**
     * Updates service definition according to normalized configuration.
     */
    private function updateServiceDefinition(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ServiceDefinition $definition, \stdClass $config) : void
    {
        if ($config->factory) {
            $definition->setFactory(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Helpers::filterArguments([$config->factory])[0]);
            $definition->setType(null);
        }
        if ($config->type) {
            $definition->setType($config->type);
        }
        if ($config->arguments) {
            $arguments = \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Helpers::filterArguments($config->arguments);
            if (empty($config->reset['arguments']) && !\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Utils\Arrays::isList($arguments)) {
                $arguments += $definition->getFactory()->arguments;
            }
            $definition->setArguments($arguments);
        }
        if (isset($config->setup)) {
            if (!empty($config->reset['setup'])) {
                $definition->setSetup([]);
            }
            foreach (\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Helpers::filterArguments($config->setup) as $id => $setup) {
                if (\is_array($setup)) {
                    $setup = new \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement(\key($setup), \array_values($setup));
                }
                $definition->addSetup($setup);
            }
        }
        if (isset($config->inject)) {
            $definition->addTag(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Extensions\InjectExtension::TAG_INJECT, $config->inject);
        }
    }
    private function updateAccessorDefinition(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\AccessorDefinition $definition, \stdClass $config) : void
    {
        if (isset($config->implement)) {
            $definition->setImplement($config->implement);
        }
        if ($ref = $config->factory ?? $config->type ?? null) {
            $definition->setReference($ref);
        }
    }
    private function updateFactoryDefinition(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\FactoryDefinition $definition, \stdClass $config) : void
    {
        $resultDef = $definition->getResultDefinition();
        if (isset($config->implement)) {
            $definition->setImplement($config->implement);
            $definition->setAutowired(\true);
        }
        if ($config->factory) {
            $resultDef->setFactory(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Helpers::filterArguments([$config->factory])[0]);
        }
        if ($config->type) {
            $resultDef->setFactory($config->type);
        }
        if ($config->arguments) {
            $arguments = \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Helpers::filterArguments($config->arguments);
            if (empty($config->reset['arguments']) && !\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Utils\Arrays::isList($arguments)) {
                $arguments += $resultDef->getFactory()->arguments;
            }
            $resultDef->setArguments($arguments);
        }
        if (isset($config->setup)) {
            if (!empty($config->reset['setup'])) {
                $resultDef->setSetup([]);
            }
            foreach (\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Helpers::filterArguments($config->setup) as $id => $setup) {
                if (\is_array($setup)) {
                    $setup = new \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement(\key($setup), \array_values($setup));
                }
                $resultDef->addSetup($setup);
            }
        }
        if (isset($config->parameters)) {
            $definition->setParameters($config->parameters);
        }
        if (isset($config->inject)) {
            $definition->addTag(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Extensions\InjectExtension::TAG_INJECT, $config->inject);
        }
    }
    private function updateLocatorDefinition(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\LocatorDefinition $definition, \stdClass $config) : void
    {
        if (isset($config->implement)) {
            $definition->setImplement($config->implement);
        }
        if (isset($config->references)) {
            $definition->setReferences($config->references);
        }
        if (isset($config->tagged)) {
            $definition->setTagged($config->tagged);
        }
    }
    private function updateImportedDefinition(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ImportedDefinition $definition, \stdClass $config) : void
    {
        if ($config->type) {
            $definition->setType($config->type);
        }
    }
    private function updateDefinition(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Definition $definition, \stdClass $config) : void
    {
        if (isset($config->autowired)) {
            $definition->setAutowired($config->autowired);
        }
        if (isset($config->tags)) {
            if (!empty($config->reset['tags'])) {
                $definition->setTags([]);
            }
            foreach ($config->tags as $tag => $attrs) {
                if (\is_int($tag) && \is_string($attrs)) {
                    $definition->addTag($attrs);
                } else {
                    $definition->addTag($tag, $attrs);
                }
            }
        }
    }
    private function convertKeyToName($key) : ?string
    {
        if (\is_int($key)) {
            return null;
        } elseif (\preg_match('#^@[\\w\\\\]+$#D', $key)) {
            return $this->getContainerBuilder()->getByType(\substr($key, 1), \true);
        }
        return $key;
    }
    private function retrieveDefinition(?string $name, \stdClass $config) : \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Definition
    {
        $builder = $this->getContainerBuilder();
        if (!empty($config->reset['all'])) {
            $builder->removeDefinition($name);
        }
        return $name && $builder->hasDefinition($name) ? $builder->getDefinition($name) : $builder->addDefinition($name, new $config->defType());
    }
}
