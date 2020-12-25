<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator;

use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Definition;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DefaultsConfigurator extends \_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractServiceConfigurator
{
    public const FACTORY = 'defaults';
    use Traits\AutoconfigureTrait;
    use Traits\AutowireTrait;
    use Traits\BindTrait;
    use Traits\PublicTrait;
    private $path;
    public function __construct(\_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator $parent, \_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Definition $definition, string $path = null)
    {
        parent::__construct($parent, $definition, null, []);
        $this->path = $path;
    }
    /**
     * Adds a tag for this definition.
     *
     * @return $this
     *
     * @throws InvalidArgumentException when an invalid tag name or attribute is provided
     */
    public final function tag(string $name, array $attributes = []) : self
    {
        if ('' === $name) {
            throw new \_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException('The tag name in "_defaults" must be a non-empty string.');
        }
        foreach ($attributes as $attribute => $value) {
            if (null !== $value && !\is_scalar($value)) {
                throw new \_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('Tag "%s", attribute "%s" in "_defaults" must be of a scalar-type.', $name, $attribute));
            }
        }
        $this->definition->addTag($name, $attributes);
        return $this;
    }
    /**
     * Defines an instanceof-conditional to be applied to following service definitions.
     */
    public final function instanceof(string $fqcn) : \_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\InstanceofConfigurator
    {
        return $this->parent->instanceof($fqcn);
    }
}
