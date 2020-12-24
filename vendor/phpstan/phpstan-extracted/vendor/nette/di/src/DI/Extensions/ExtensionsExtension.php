<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Extensions;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette;
/**
 * Enables registration of other extensions in $config file
 */
final class ExtensionsExtension extends \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::arrayOf('_PhpScoperb75b35f52b74\\string|_HumbugBox221ad6f1b81f\\Nette\\DI\\Definitions\\Statement');
    }
    public function loadConfiguration()
    {
        foreach ($this->getConfig() as $name => $class) {
            if (\is_int($name)) {
                $name = null;
            }
            $args = [];
            if ($class instanceof \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement) {
                [$class, $args] = [$class->getEntity(), $class->arguments];
            }
            if (!\is_a($class, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\CompilerExtension::class, \true)) {
                throw new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\InvalidConfigurationException("Extension '{$class}' not found or is not Nette\\DI\\CompilerExtension descendant.");
            }
            $this->compiler->addExtension($name, (new \ReflectionClass($class))->newInstanceArgs($args));
        }
    }
}