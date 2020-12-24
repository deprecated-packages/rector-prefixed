<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Config;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Context;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Schema;
/**
 * Service configuration schema.
 */
class DefinitionSchema implements \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
{
    use Nette\SmartObject;
    /** @var Nette\DI\ContainerBuilder */
    private $builder;
    public function __construct(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\ContainerBuilder $builder)
    {
        $this->builder = $builder;
    }
    public function complete($def, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Context $context)
    {
        if ($def === [\false]) {
            return (object) $def;
        }
        if (\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Config\Helpers::takeParent($def)) {
            $def['reset']['all'] = \true;
        }
        foreach (['arguments', 'setup', 'tags'] as $k) {
            if (isset($def[$k]) && \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Config\Helpers::takeParent($def[$k])) {
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
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Helpers::merge($def, $base);
    }
    /**
     * Normalizes configuration of service definitions.
     */
    public function normalize($def, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Context $context)
    {
        if ($def === null || $def === \false) {
            return (array) $def;
        } elseif (\is_string($def) && \interface_exists($def)) {
            return ['implement' => $def];
        } elseif ($def instanceof \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement && \is_string($def->getEntity()) && \interface_exists($def->getEntity())) {
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
                if ($def['class'] instanceof \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement) {
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
                        throw new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\InvalidConfigurationException("Options '{$alias}' and '{$original}' are aliases, use only '{$original}'.");
                    }
                    $def[$original] = $def[$alias];
                    unset($def[$alias]);
                }
            }
            return $def;
        } else {
            throw new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\InvalidConfigurationException('Unexpected format of service definition');
        }
    }
    public function completeDefault(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Context $context)
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
            return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\LocatorDefinition::class;
        } elseif (isset($def['implement'])) {
            return \method_exists($def['implement'], 'create') ? \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\FactoryDefinition::class : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\AccessorDefinition::class;
        } elseif (isset($def['imported'])) {
            return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ImportedDefinition::class;
        } else {
            return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ServiceDefinition::class;
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
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Helpers::expand($config, $params);
    }
    private static function getSchema(string $type) : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        static $cache;
        $cache = $cache ?: [\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ServiceDefinition::class => self::getServiceSchema(), \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\AccessorDefinition::class => self::getAccessorSchema(), \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\FactoryDefinition::class => self::getFactorySchema(), \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\LocatorDefinition::class => self::getLocatorSchema(), \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\ImportedDefinition::class => self::getImportedSchema()];
        return $cache[$type];
    }
    private static function getServiceSchema() : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::structure(['type' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('string'), 'factory' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('_PhpScoperb75b35f52b74\\callable|_HumbugBox221ad6f1b81f\\Nette\\DI\\Definitions\\Statement'), 'arguments' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'setup' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::listOf('callable|_HumbugBox221ad6f1b81f\\Nette\\DI\\Definitions\\Statement|array:1'), 'inject' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::bool(), 'autowired' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'reset' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'alteration' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::bool()]);
    }
    private static function getAccessorSchema() : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::structure(['type' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'implement' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'factory' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('_PhpScoperb75b35f52b74\\callable|_HumbugBox221ad6f1b81f\\Nette\\DI\\Definitions\\Statement'), 'autowired' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array()]);
    }
    private static function getFactorySchema() : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::structure(['type' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'factory' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('_PhpScoperb75b35f52b74\\callable|_HumbugBox221ad6f1b81f\\Nette\\DI\\Definitions\\Statement'), 'implement' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'arguments' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'setup' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::listOf('callable|_HumbugBox221ad6f1b81f\\Nette\\DI\\Definitions\\Statement|array:1'), 'parameters' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'references' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'tagged' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'inject' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::bool(), 'autowired' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'reset' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array()]);
    }
    private static function getLocatorSchema() : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::structure(['implement' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'references' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'tagged' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'autowired' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array()]);
    }
    private static function getImportedSchema() : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::structure(['type' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::string(), 'imported' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::bool(), 'autowired' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type('bool|string|array'), 'tags' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array()]);
    }
}
