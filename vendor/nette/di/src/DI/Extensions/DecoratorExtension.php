<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Nette\DI\Extensions;

use _PhpScopera143bcca66cb\Nette;
use _PhpScopera143bcca66cb\Nette\DI\Definitions;
use _PhpScopera143bcca66cb\Nette\Schema\Expect;
/**
 * Decorators for services.
 */
final class DecoratorExtension extends \_PhpScopera143bcca66cb\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_PhpScopera143bcca66cb\Nette\Schema\Schema
    {
        return \_PhpScopera143bcca66cb\Nette\Schema\Expect::arrayOf(\_PhpScopera143bcca66cb\Nette\Schema\Expect::structure(['setup' => \_PhpScopera143bcca66cb\Nette\Schema\Expect::list(), 'tags' => \_PhpScopera143bcca66cb\Nette\Schema\Expect::array(), 'inject' => \_PhpScopera143bcca66cb\Nette\Schema\Expect::bool()]));
    }
    public function beforeCompile()
    {
        $this->getContainerBuilder()->resolve();
        foreach ($this->config as $type => $info) {
            if ($info->inject !== null) {
                $info->tags[\_PhpScopera143bcca66cb\Nette\DI\Extensions\InjectExtension::TAG_INJECT] = $info->inject;
            }
            $this->addSetups($type, \_PhpScopera143bcca66cb\Nette\DI\Helpers::filterArguments($info->setup));
            $this->addTags($type, \_PhpScopera143bcca66cb\Nette\DI\Helpers::filterArguments($info->tags));
        }
    }
    public function addSetups(string $type, array $setups) : void
    {
        foreach ($this->findByType($type) as $def) {
            if ($def instanceof \_PhpScopera143bcca66cb\Nette\DI\Definitions\FactoryDefinition) {
                $def = $def->getResultDefinition();
            }
            foreach ($setups as $setup) {
                if (\is_array($setup)) {
                    $setup = new \_PhpScopera143bcca66cb\Nette\DI\Definitions\Statement(\key($setup), \array_values($setup));
                }
                $def->addSetup($setup);
            }
        }
    }
    public function addTags(string $type, array $tags) : void
    {
        $tags = \_PhpScopera143bcca66cb\Nette\Utils\Arrays::normalize($tags, \true);
        foreach ($this->findByType($type) as $def) {
            $def->setTags($def->getTags() + $tags);
        }
    }
    private function findByType(string $type) : array
    {
        return \array_filter($this->getContainerBuilder()->getDefinitions(), function (\_PhpScopera143bcca66cb\Nette\DI\Definitions\Definition $def) use($type) : bool {
            return \is_a($def->getType(), $type, \true) || $def instanceof \_PhpScopera143bcca66cb\Nette\DI\Definitions\FactoryDefinition && \is_a($def->getResultType(), $type, \true);
        });
    }
}
