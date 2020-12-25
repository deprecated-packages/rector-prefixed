<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Argument;

/**
 * Represents a complex argument containing nested values.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
interface ArgumentInterface
{
    /**
     * @return array
     */
    public function getValues();
    public function setValues(array $values);
}
