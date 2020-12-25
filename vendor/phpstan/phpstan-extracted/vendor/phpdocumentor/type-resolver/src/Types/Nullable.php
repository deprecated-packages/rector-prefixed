<?php

declare (strict_types=1);
/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      http://phpdoc.org
 */
namespace _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types;

use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Type;
/**
 * Value Object representing a nullable type. The real type is wrapped.
 *
 * @psalm-immutable
 */
final class Nullable implements \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Type
{
    /** @var Type The actual type that is wrapped */
    private $realType;
    /**
     * Initialises this nullable type using the real type embedded
     */
    public function __construct(\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Type $realType)
    {
        $this->realType = $realType;
    }
    /**
     * Provide access to the actual type directly, if needed.
     */
    public function getActualType() : \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Type
    {
        return $this->realType;
    }
    /**
     * Returns a rendered output of the Type as it would be used in a DocBlock.
     */
    public function __toString() : string
    {
        return '?' . $this->realType->__toString();
    }
}
