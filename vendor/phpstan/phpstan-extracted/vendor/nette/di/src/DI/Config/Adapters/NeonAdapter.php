<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Config\Adapters;

use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Config\Helpers;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Reference;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Neon;
/**
 * Reading and generating NEON files.
 */
final class NeonAdapter implements \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Config\Adapter
{
    use Nette\SmartObject;
    private const PREVENT_MERGING_SUFFIX = '!';
    /**
     * Reads configuration from NEON file.
     */
    public function load(string $file) : array
    {
        return $this->process((array) \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Neon\Neon::decode(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Utils\FileSystem::read($file)));
    }
    /** @throws Nette\InvalidStateException */
    public function process(array $arr) : array
    {
        $res = [];
        foreach ($arr as $key => $val) {
            if (\is_string($key) && \substr($key, -1) === self::PREVENT_MERGING_SUFFIX) {
                if (!\is_array($val) && $val !== null) {
                    throw new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\InvalidConfigurationException("Replacing operator is available only for arrays, item '{$key}' is not array.");
                }
                $key = \substr($key, 0, -1);
                $val[\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Config\Helpers::PREVENT_MERGING] = \true;
            }
            if (\is_array($val)) {
                $val = $this->process($val);
            } elseif ($val instanceof \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Neon\Entity) {
                if ($val->value === \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Neon\Neon::CHAIN) {
                    $tmp = null;
                    foreach ($this->process($val->attributes) as $st) {
                        $tmp = new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement($tmp === null ? $st->getEntity() : [$tmp, \ltrim(\implode('::', (array) $st->getEntity()), ':')], $st->arguments);
                    }
                    $val = $tmp;
                } else {
                    $tmp = $this->process([$val->value]);
                    if (\is_string($tmp[0]) && \strpos($tmp[0], '?') !== \false) {
                        \trigger_error('Operator ? is deprecated in config files.', \E_USER_DEPRECATED);
                    }
                    $val = new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement($tmp[0], $this->process($val->attributes));
                }
            }
            $res[$key] = $val;
        }
        return $res;
    }
    /**
     * Generates configuration in NEON format.
     */
    public function dump(array $data) : string
    {
        \array_walk_recursive($data, function (&$val) : void {
            if ($val instanceof \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement) {
                $val = self::statementToEntity($val);
            }
        });
        return "# generated by Nette\n\n" . \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Neon\Neon::encode($data, \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Neon\Neon::BLOCK);
    }
    private static function statementToEntity(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement $val) : \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Neon\Entity
    {
        \array_walk_recursive($val->arguments, function (&$val) : void {
            if ($val instanceof \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement) {
                $val = self::statementToEntity($val);
            } elseif ($val instanceof \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Reference) {
                $val = '@' . $val->getValue();
            }
        });
        $entity = $val->getEntity();
        if ($entity instanceof \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Reference) {
            $entity = '@' . $entity->getValue();
        } elseif (\is_array($entity)) {
            if ($entity[0] instanceof \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement) {
                return new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Neon\Entity(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Neon\Neon::CHAIN, [self::statementToEntity($entity[0]), new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Neon\Entity('::' . $entity[1], $val->arguments)]);
            } elseif ($entity[0] instanceof \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Reference) {
                $entity = '@' . $entity[0]->getValue() . '::' . $entity[1];
            } elseif (\is_string($entity[0])) {
                $entity = $entity[0] . '::' . $entity[1];
            }
        }
        return new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Neon\Entity($entity, $val->arguments);
    }
}
