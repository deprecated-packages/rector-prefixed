<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Compiler;

use _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Reference;
final class AliasDeprecatedPublicServicesPass extends \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass
{
    private $tagName;
    private $aliases = [];
    public function __construct(string $tagName = 'container.private')
    {
        $this->tagName = $tagName;
    }
    /**
     * {@inheritdoc}
     */
    protected function processValue($value, bool $isRoot = \false)
    {
        if ($value instanceof \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Reference && isset($this->aliases[$id = (string) $value])) {
            return new \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Reference($this->aliases[$id], $value->getInvalidBehavior());
        }
        return parent::processValue($value, $isRoot);
    }
    /**
     * {@inheritdoc}
     */
    public function process(\_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds($this->tagName) as $id => $tags) {
            if (null === ($package = $tags[0]['package'] ?? null)) {
                throw new \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('The "package" attribute is mandatory for the "%s" tag on the "%s" service.', $this->tagName, $id));
            }
            if (null === ($version = $tags[0]['version'] ?? null)) {
                throw new \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('The "version" attribute is mandatory for the "%s" tag on the "%s" service.', $this->tagName, $id));
            }
            $definition = $container->getDefinition($id);
            if (!$definition->isPublic() || $definition->isPrivate()) {
                throw new \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('The "%s" service is private: it cannot have the "%s" tag.', $id, $this->tagName));
            }
            $container->setAlias($id, $aliasId = '.' . $this->tagName . '.' . $id)->setPublic(\true)->setDeprecated($package, $version, 'Accessing the "%alias_id%" service directly from the container is deprecated, use dependency injection instead.');
            $container->setDefinition($aliasId, $definition);
            $this->aliases[$id] = $aliasId;
        }
        parent::process($container);
    }
}
