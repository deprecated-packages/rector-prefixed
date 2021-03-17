<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210317\Symfony\Component\DependencyInjection\Loader\Configurator;

use RectorPrefix20210317\Symfony\Component\DependencyInjection\Definition;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class InstanceofConfigurator extends \RectorPrefix20210317\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractServiceConfigurator
{
    public const FACTORY = 'instanceof';
    use Traits\AutowireTrait;
    use Traits\BindTrait;
    use Traits\CallTrait;
    use Traits\ConfiguratorTrait;
    use Traits\LazyTrait;
    use Traits\PropertyTrait;
    use Traits\PublicTrait;
    use Traits\ShareTrait;
    use Traits\TagTrait;
    private $path;
    /**
     * @param \Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator $parent
     * @param \Symfony\Component\DependencyInjection\Definition $definition
     * @param string $id
     * @param string $path
     */
    public function __construct($parent, $definition, $id, $path = null)
    {
        parent::__construct($parent, $definition, $id, []);
        $this->path = $path;
    }
    /**
     * Defines an instanceof-conditional to be applied to following service definitions.
     * @return $this
     * @param string $fqcn
     */
    public final function instanceof($fqcn)
    {
        return $this->parent->instanceof($fqcn);
    }
}
