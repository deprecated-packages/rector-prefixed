<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Nette\DI\Extensions;

use _PhpScoper88fe6e0ad041\Nette;
use _PhpScoper88fe6e0ad041\Nette\DI\Definitions;
use _PhpScoper88fe6e0ad041\Nette\Schema\Expect;
/**
 * Decorators for services.
 */
final class DecoratorExtension extends \_PhpScoper88fe6e0ad041\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_PhpScoper88fe6e0ad041\Nette\Schema\Schema
    {
        return \_PhpScoper88fe6e0ad041\Nette\Schema\Expect::arrayOf(\_PhpScoper88fe6e0ad041\Nette\Schema\Expect::structure(['setup' => \_PhpScoper88fe6e0ad041\Nette\Schema\Expect::list(), 'tags' => \_PhpScoper88fe6e0ad041\Nette\Schema\Expect::array(), 'inject' => \_PhpScoper88fe6e0ad041\Nette\Schema\Expect::bool()]));
    }
    public function beforeCompile()
    {
        $this->getContainerBuilder()->resolve();
        foreach ($this->config as $type => $info) {
            if ($info->inject !== null) {
                $info->tags[\_PhpScoper88fe6e0ad041\Nette\DI\Extensions\InjectExtension::TAG_INJECT] = $info->inject;
            }
            $this->addSetups($type, \_PhpScoper88fe6e0ad041\Nette\DI\Helpers::filterArguments($info->setup));
            $this->addTags($type, \_PhpScoper88fe6e0ad041\Nette\DI\Helpers::filterArguments($info->tags));
        }
    }
    public function addSetups(string $type, array $setups) : void
    {
        foreach ($this->findByType($type) as $def) {
            if ($def instanceof \_PhpScoper88fe6e0ad041\Nette\DI\Definitions\FactoryDefinition) {
                $def = $def->getResultDefinition();
            }
            foreach ($setups as $setup) {
                if (\is_array($setup)) {
                    $setup = new \_PhpScoper88fe6e0ad041\Nette\DI\Definitions\Statement(\key($setup), \array_values($setup));
                }
                $def->addSetup($setup);
            }
        }
    }
    public function addTags(string $type, array $tags) : void
    {
        $tags = \_PhpScoper88fe6e0ad041\Nette\Utils\Arrays::normalize($tags, \true);
        foreach ($this->findByType($type) as $def) {
            $def->setTags($def->getTags() + $tags);
        }
    }
    private function findByType(string $type) : array
    {
        return \array_filter($this->getContainerBuilder()->getDefinitions(), function (\_PhpScoper88fe6e0ad041\Nette\DI\Definitions\Definition $def) use($type) : bool {
            return \is_a($def->getType(), $type, \true) || $def instanceof \_PhpScoper88fe6e0ad041\Nette\DI\Definitions\FactoryDefinition && \is_a($def->getResultType(), $type, \true);
        });
    }
}
