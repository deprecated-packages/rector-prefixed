<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Config;

use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Context;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Schema;
/**
 * Service configuration schema.
 */
class DefinitionSchema implements \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
{
    use Nette\SmartObject;
    /** @var Nette\DI\ContainerBuilder */
    private $builder;
    public function __construct(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\ContainerBuilder $builder)
    {
        $this->builder = $builder;
    }
    public function complete($def, \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Context $context)
    {
        if ($def === [\false]) {
            return (object) $def;
        }
        if (\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Config\Helpers::takeParent($def)) {
            $def['reset']['all'] = \true;
        }
        foreach (['arguments', 'setup', 'tags'] as $k) {
            if (isset($def[$k]) && \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Config\Helpers::takeParent($def[$k])) {
                $def['reset'][$k] = \true;
            }
        }
        $def = $this->expandParameters($def);
        $type = $this->sniffType(\end($context->path), $def);
        $def = $this->getSchema($type)->complete($def, $context);
        if ($def) {
            $def->defType = $type;
        }
        return $def;
    }
    public function merge($def, $base)
    {
        if (!empty($def['alteration'])) {
            unset($def['alteration']);
        }
        return \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Helpers::merge($def, $base);
    }
    /**
     * Normalizes configuration of service definitions.
     */
    public function normalize($def, \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Context $context)
    {
        if ($def === null || $def === \false) {
            return (array) $def;
        } elseif (\is_string($def) && \interface_exists($def)) {
            return ['implement' => $def];
        } elseif ($def instanceof \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement && \is_string($def->getEntity()) && \interface_exists($def->getEntity())) {
            $res = ['implement' => $def->getEntity()];
            if (\array_keys($def->arguments) === ['tagged']) {
                $res += $def->arguments;
            } elseif (\count($def->arguments) > 1) {
                $res['references'] = $def->arguments;
            } elseif ($factory = \array_shift($def->arguments)) {
                $res['factory'] = $factory;
            }
            return $res;
        } elseif (!\is_array($def) || isset($def[0], $def[1])) {
            return ['factory' => $def];
        } elseif (\is_array($def)) {
            if (isset($def['class']) && !isset($def['type'])) {
                if ($def['class'] instanceof \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement) {
                    $key = \end($context->path);
                    \trigger_error("Service '{$key}': option 'class' should be changed to 'factory'.", \E_USER_DEPRECATED);
                    $def['factory'] = $def['class'];
                    unset($def['class']);
                } elseif (!isset($def['factory']) && !isset($def['dynamic']) && !isset($def['imported'])) {
                    $def['factory'] = $def['class'];
                    unset($def['class']);
                }
            }
            foreach (['class' => 'type', 'dynamic' => 'imported'] as $alias => $original) {
                if (\array_key_exists($alias, $def)) {
                    if (\array_key_exists($original, $def)) {
                        throw new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\InvalidConfigurationException("Options '{$alias}' and '{$original}' are aliases, use only '{$original}'.");
                    }
                    $def[$original] = $def[$alias];
                    unset($def[$alias]);
                }
            }
            return $def;
        } else {
            throw new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\InvalidConfigurationException('Unexpected format of service definition');
        }
    }
    public function completeDefault(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Context $context)
    {
    }
    private function sniffType($key, array $def) : string
    {
        if (\is_string($key)) {
            $name = \preg_match('#^@[\\w\\\\]+$#D', $key) ? $this->builder->getByType(\substr($key, 1), \false) : $key;
            if ($name && $this->builder->hasDefinition($name)) {
                return \get_class($this->builder->getDefinition($name));
            }
        }
        if (isset($def['implement'], $def['references']) || isset($def['implement'], $def['tagged'])) {
            return \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\LocatorDefinition::class;
        } elseif (isset($def['implement'])) {
            return \method_exists($def['implement'], 'create') ? \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\FactoryDefinition::class : \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\AccessorDefinition::class;
        } elseif (isset($def['imported'])) {
            return \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ImportedDefinition::class;
        } else {
            return \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ServiceDefinition::class;
        }
    }
    private function expandParameters(array $config) : array
    {
        $params = $this->builder->parameters;
        if (isset($config['parameters'])) {
            foreach ((array) $config['parameters'] as $k => $v) {
                $v = \explode(' ', \is_int($k) ? $v : $k);
                $params[\end($v)] = $this->builder::literal('$' . \end($v));
            }
        }
        return \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Helpers::expand($config, $params);
    }
    private static function getSchema(string $type) : \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        static $cache;
        $cache = $cache ?: [\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ServiceDefinition::class => self::getServiceSchema(), \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\AccessorDefinition::class => self::getAccessorSchema(), \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\FactoryDefinition::class => self::getFactorySchema(), \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\LocatorDefinition::class => self::getLocatorSchema(), \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ImportedDefinition::class => self::getImportedSchema()];
        return $cache[$type];
    }
    private static function getServiceSchema() : \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::structure(['type' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('string'), 'factory' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('_PhpScoper0a6b37af0871\\callable|_HumbugBox221ad6f1b81f\\Nette\\DI\\Definitions\\Statement'), 'arguments' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'setup' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::listOf('callable|_HumbugBox221ad6f1b81f\\Nette\\DI\\Definitions\\Statement|array:1'), 'inject' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::bool(), 'autowired' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'reset' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'alteration' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::bool()]);
    }
    private static function getAccessorSchema() : \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::structure(['type' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'implement' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'factory' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('_PhpScoper0a6b37af0871\\callable|_HumbugBox221ad6f1b81f\\Nette\\DI\\Definitions\\Statement'), 'autowired' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array()]);
    }
    private static function getFactorySchema() : \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::structure(['type' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'factory' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('_PhpScoper0a6b37af0871\\callable|_HumbugBox221ad6f1b81f\\Nette\\DI\\Definitions\\Statement'), 'implement' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'arguments' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'setup' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::listOf('callable|_HumbugBox221ad6f1b81f\\Nette\\DI\\Definitions\\Statement|array:1'), 'parameters' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'references' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'tagged' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'inject' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::bool(), 'autowired' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'reset' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array()]);
    }
    private static function getLocatorSchema() : \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::structure(['implement' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'references' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'tagged' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'autowired' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array()]);
    }
    private static function getImportedSchema() : \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::structure(['type' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'imported' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::bool(), 'autowired' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array()]);
    }
}
