<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Compiler;

use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
/**
 * Resolves all TaggedIteratorArgument arguments.
 *
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class ResolveTaggedIteratorArgumentPass extends \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass
{
    use PriorityTaggedServiceTrait;
    /**
     * {@inheritdoc}
     */
    protected function processValue($value, bool $isRoot = \false)
    {
        if (!$value instanceof \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument) {
            return parent::processValue($value, $isRoot);
        }
        $value->setValues($this->findAndSortTaggedServices($value, $this->container));
        return $value;
    }
}
