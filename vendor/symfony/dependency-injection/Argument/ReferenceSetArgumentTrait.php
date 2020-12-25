<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\Argument;

use _PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use _PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\Reference;
/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Nicolas Grekas <p@tchwork.com>
 */
trait ReferenceSetArgumentTrait
{
    private $values;
    /**
     * @param Reference[] $values
     */
    public function __construct(array $values)
    {
        $this->setValues($values);
    }
    /**
     * @return Reference[] The values in the set
     */
    public function getValues()
    {
        return $this->values;
    }
    /**
     * @param Reference[] $values The service references to put in the set
     */
    public function setValues(array $values)
    {
        foreach ($values as $k => $v) {
            if (null !== $v && !$v instanceof \_PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\Reference) {
                throw new \_PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('A "%s" must hold only Reference instances, "%s" given.', __CLASS__, \get_debug_type($v)));
            }
        }
        $this->values = $values;
    }
}
