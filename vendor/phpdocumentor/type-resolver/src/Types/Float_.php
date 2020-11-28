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
namespace _PhpScoperabd03f0baf05\phpDocumentor\Reflection\Types;

use _PhpScoperabd03f0baf05\phpDocumentor\Reflection\Type;
/**
 * Value Object representing a Float.
 *
 * @psalm-immutable
 */
final class Float_ implements \_PhpScoperabd03f0baf05\phpDocumentor\Reflection\Type
{
    /**
     * Returns a rendered output of the Type as it would be used in a DocBlock.
     */
    public function __toString() : string
    {
        return 'float';
    }
}
