<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Nette\DI\Extensions;

use _PhpScopera143bcca66cb\Nette;
/**
 * Enables registration of other extensions in $config file
 */
final class ExtensionsExtension extends \_PhpScopera143bcca66cb\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_PhpScopera143bcca66cb\Nette\Schema\Schema
    {
        return \_PhpScopera143bcca66cb\Nette\Schema\Expect::arrayOf('_PhpScopera143bcca66cb\\string|Nette\\DI\\Definitions\\Statement');
    }
    public function loadConfiguration()
    {
        foreach ($this->getConfig() as $name => $class) {
            if (\is_int($name)) {
                $name = null;
            }
            $args = [];
            if ($class instanceof \_PhpScopera143bcca66cb\Nette\DI\Definitions\Statement) {
                [$class, $args] = [$class->getEntity(), $class->arguments];
            }
            if (!\is_a($class, \_PhpScopera143bcca66cb\Nette\DI\CompilerExtension::class, \true)) {
                throw new \_PhpScopera143bcca66cb\Nette\DI\InvalidConfigurationException("Extension '{$class}' not found or is not Nette\\DI\\CompilerExtension descendant.");
            }
            $this->compiler->addExtension($name, (new \ReflectionClass($class))->newInstanceArgs($args));
        }
    }
}
