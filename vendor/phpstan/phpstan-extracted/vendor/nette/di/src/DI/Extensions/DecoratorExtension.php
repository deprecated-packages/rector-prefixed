<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Nette\DI\Extensions;

use _HumbugBox221ad6f1b81f\Nette;
use _HumbugBox221ad6f1b81f\Nette\DI\Definitions;
use _HumbugBox221ad6f1b81f\Nette\Schema\Expect;
/**
 * Decorators for services.
 */
final class DecoratorExtension extends \_HumbugBox221ad6f1b81f\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_HumbugBox221ad6f1b81f\Nette\Schema\Expect::arrayOf(\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::structure(['setup' => \_HumbugBox221ad6f1b81f\Nette\Schema\Expect::list(), 'tags' => \_HumbugBox221ad6f1b81f\Nette\Schema\Expect::array(), 'inject' => \_HumbugBox221ad6f1b81f\Nette\Schema\Expect::bool()]));
    }
    public function beforeCompile()
    {
        $this->getContainerBuilder()->resolve();
        foreach ($this->config as $type => $info) {
            if ($info->inject !== null) {
                $info->tags[\_HumbugBox221ad6f1b81f\Nette\DI\Extensions\InjectExtension::TAG_INJECT] = $info->inject;
            }
            $this->addSetups($type, \_HumbugBox221ad6f1b81f\Nette\DI\Helpers::filterArguments($info->setup));
            $this->addTags($type, \_HumbugBox221ad6f1b81f\Nette\DI\Helpers::filterArguments($info->tags));
        }
    }
    public function addSetups(string $type, array $setups) : void
    {
        foreach ($this->findByType($type) as $def) {
            if ($def instanceof \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\FactoryDefinition) {
                $def = $def->getResultDefinition();
            }
            foreach ($setups as $setup) {
                if (\is_array($setup)) {
                    $setup = new \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement(\key($setup), \array_values($setup));
                }
                $def->addSetup($setup);
            }
        }
    }
    public function addTags(string $type, array $tags) : void
    {
        $tags = \_HumbugBox221ad6f1b81f\Nette\Utils\Arrays::normalize($tags, \true);
        foreach ($this->findByType($type) as $def) {
            $def->setTags($def->getTags() + $tags);
        }
    }
    private function findByType(string $type) : array
    {
        return \array_filter($this->getContainerBuilder()->getDefinitions(), function (\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Definition $def) use($type) : bool {
            return \is_a($def->getType(), $type, \true) || $def instanceof \_HumbugBox221ad6f1b81f\Nette\DI\Definitions\FactoryDefinition && \is_a($def->getResultType(), $type, \true);
        });
    }
}
