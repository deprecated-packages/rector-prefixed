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
namespace _PhpScoper26e51eeacccf\phpDocumentor\Reflection\Types;

use _PhpScoper26e51eeacccf\phpDocumentor\Reflection\Type;
/**
 * Represents an expression type as described in the PSR-5, the PHPDoc Standard.
 *
 * @psalm-immutable
 */
final class Expression implements \_PhpScoper26e51eeacccf\phpDocumentor\Reflection\Type
{
    /** @var Type */
    protected $valueType;
    /**
     * Initializes this representation of an array with the given Type.
     */
    public function __construct(\_PhpScoper26e51eeacccf\phpDocumentor\Reflection\Type $valueType)
    {
        $this->valueType = $valueType;
    }
    /**
     * Returns the value for the keys of this array.
     */
    public function getValueType() : \_PhpScoper26e51eeacccf\phpDocumentor\Reflection\Type
    {
        return $this->valueType;
    }
    /**
     * Returns a rendered output of the Type as it would be used in a DocBlock.
     */
    public function __toString() : string
    {
        return '(' . $this->valueType . ')';
    }
}
