<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Nette\DI\Config;

use _PhpScoperabd03f0baf05\Nette;
use _PhpScoperabd03f0baf05\Nette\DI\Definitions;
use _PhpScoperabd03f0baf05\Nette\DI\Definitions\Statement;
use _PhpScoperabd03f0baf05\Nette\Schema\Context;
use _PhpScoperabd03f0baf05\Nette\Schema\Expect;
use _PhpScoperabd03f0baf05\Nette\Schema\Schema;
/**
 * Service configuration schema.
 */
class DefinitionSchema implements \_PhpScoperabd03f0baf05\Nette\Schema\Schema
{
    use Nette\SmartObject;
    /** @var Nette\DI\ContainerBuilder */
    private $builder;
    public function __construct(\_PhpScoperabd03f0baf05\Nette\DI\ContainerBuilder $builder)
    {
        $this->builder = $builder;
    }
    public function complete($def, \_PhpScoperabd03f0baf05\Nette\Schema\Context $context)
    {
        if ($def === [\false]) {
            return (object) $def;
        }
        if (\_PhpScoperabd03f0baf05\Nette\DI\Config\Helpers::takeParent($def)) {
            $def['reset']['all'] = \true;
        }
        foreach (['arguments', 'setup', 'tags'] as $k) {
            if (isset($def[$k]) && \_PhpScoperabd03f0baf05\Nette\DI\Config\Helpers::takeParent($def[$k])) {
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
        return \_PhpScoperabd03f0baf05\Nette\Schema\Helpers::merge($def, $base);
    }
    /**
     * Normalizes configuration of service definitions.
     */
    public function normalize($def, \_PhpScoperabd03f0baf05\Nette\Schema\Context $context)
    {
        if ($def === null || $def === \false) {
            return (array) $def;
        } elseif (\is_string($def) && \interface_exists($def)) {
            return ['implement' => $def];
        } elseif ($def instanceof \_PhpScoperabd03f0baf05\Nette\DI\Definitions\Statement && \is_string($def->getEntity()) && \interface_exists($def->getEntity())) {
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
                if ($def['class'] instanceof \_PhpScoperabd03f0baf05\Nette\DI\Definitions\Statement) {
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
                        throw new \_PhpScoperabd03f0baf05\Nette\DI\InvalidConfigurationException("Options '{$alias}' and '{$original}' are aliases, use only '{$original}'.");
                    }
                    $def[$original] = $def[$alias];
                    unset($def[$alias]);
                }
            }
            return $def;
        } else {
            throw new \_PhpScoperabd03f0baf05\Nette\DI\InvalidConfigurationException('Unexpected format of service definition');
        }
    }
    public function completeDefault(\_PhpScoperabd03f0baf05\Nette\Schema\Context $context)
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
            return \_PhpScoperabd03f0baf05\Nette\DI\Definitions\LocatorDefinition::class;
        } elseif (isset($def['implement'])) {
            return \method_exists($def['implement'], 'create') ? \_PhpScoperabd03f0baf05\Nette\DI\Definitions\FactoryDefinition::class : \_PhpScoperabd03f0baf05\Nette\DI\Definitions\AccessorDefinition::class;
        } elseif (isset($def['imported'])) {
            return \_PhpScoperabd03f0baf05\Nette\DI\Definitions\ImportedDefinition::class;
        } else {
            return \_PhpScoperabd03f0baf05\Nette\DI\Definitions\ServiceDefinition::class;
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
        return \_PhpScoperabd03f0baf05\Nette\DI\Helpers::expand($config, $params);
    }
    private static function getSchema(string $type) : \_PhpScoperabd03f0baf05\Nette\Schema\Schema
    {
        static $cache;
        $cache = $cache ?: [\_PhpScoperabd03f0baf05\Nette\DI\Definitions\ServiceDefinition::class => self::getServiceSchema(), \_PhpScoperabd03f0baf05\Nette\DI\Definitions\AccessorDefinition::class => self::getAccessorSchema(), \_PhpScoperabd03f0baf05\Nette\DI\Definitions\FactoryDefinition::class => self::getFactorySchema(), \_PhpScoperabd03f0baf05\Nette\DI\Definitions\LocatorDefinition::class => self::getLocatorSchema(), \_PhpScoperabd03f0baf05\Nette\DI\Definitions\ImportedDefinition::class => self::getImportedSchema()];
        return $cache[$type];
    }
    private static function getServiceSchema() : \_PhpScoperabd03f0baf05\Nette\Schema\Schema
    {
        return \_PhpScoperabd03f0baf05\Nette\Schema\Expect::structure(['type' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::type('string'), 'factory' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::type('callable|_PhpScoperabd03f0baf05\\Nette\\DI\\Definitions\\Statement'), 'arguments' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::array(), 'setup' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::listOf('callable|_PhpScoperabd03f0baf05\\Nette\\DI\\Definitions\\Statement|array:1'), 'inject' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::bool(), 'autowired' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::array(), 'reset' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::array(), 'alteration' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::bool()]);
    }
    private static function getAccessorSchema() : \_PhpScoperabd03f0baf05\Nette\Schema\Schema
    {
        return \_PhpScoperabd03f0baf05\Nette\Schema\Expect::structure(['type' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::string(), 'implement' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::string(), 'factory' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::type('callable|_PhpScoperabd03f0baf05\\Nette\\DI\\Definitions\\Statement'), 'autowired' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::array()]);
    }
    private static function getFactorySchema() : \_PhpScoperabd03f0baf05\Nette\Schema\Schema
    {
        return \_PhpScoperabd03f0baf05\Nette\Schema\Expect::structure(['type' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::string(), 'factory' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::type('callable|_PhpScoperabd03f0baf05\\Nette\\DI\\Definitions\\Statement'), 'implement' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::string(), 'arguments' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::array(), 'setup' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::listOf('callable|_PhpScoperabd03f0baf05\\Nette\\DI\\Definitions\\Statement|array:1'), 'parameters' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::array(), 'references' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::array(), 'tagged' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::string(), 'inject' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::bool(), 'autowired' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::array(), 'reset' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::array()]);
    }
    private static function getLocatorSchema() : \_PhpScoperabd03f0baf05\Nette\Schema\Schema
    {
        return \_PhpScoperabd03f0baf05\Nette\Schema\Expect::structure(['implement' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::string(), 'references' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::array(), 'tagged' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::string(), 'autowired' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::array()]);
    }
    private static function getImportedSchema() : \_PhpScoperabd03f0baf05\Nette\Schema\Schema
    {
        return \_PhpScoperabd03f0baf05\Nette\Schema\Expect::structure(['type' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::string(), 'imported' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::bool(), 'autowired' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::array()]);
    }
}
