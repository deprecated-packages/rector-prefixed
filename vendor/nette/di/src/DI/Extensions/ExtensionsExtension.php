<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Nette\DI\Extensions;

use _PhpScoper88fe6e0ad041\Nette;
/**
 * Enables registration of other extensions in $config file
 */
final class ExtensionsExtension extends \_PhpScoper88fe6e0ad041\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_PhpScoper88fe6e0ad041\Nette\Schema\Schema
    {
        return \_PhpScoper88fe6e0ad041\Nette\Schema\Expect::arrayOf('_PhpScoper88fe6e0ad041\\string|Nette\\DI\\Definitions\\Statement');
    }
    public function loadConfiguration()
    {
        foreach ($this->getConfig() as $name => $class) {
            if (\is_int($name)) {
                $name = null;
            }
            $args = [];
            if ($class instanceof \_PhpScoper88fe6e0ad041\Nette\DI\Definitions\Statement) {
                [$class, $args] = [$class->getEntity(), $class->arguments];
            }
            if (!\is_a($class, \_PhpScoper88fe6e0ad041\Nette\DI\CompilerExtension::class, \true)) {
                throw new \_PhpScoper88fe6e0ad041\Nette\DI\InvalidConfigurationException("Extension '{$class}' not found or is not Nette\\DI\\CompilerExtension descendant.");
            }
            $this->compiler->addExtension($name, (new \ReflectionClass($class))->newInstanceArgs($args));
        }
    }
}