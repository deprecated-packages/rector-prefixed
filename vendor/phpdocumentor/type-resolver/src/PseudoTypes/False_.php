<?php

declare (strict_types=1);
/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link https://phpdoc.org
 */
namespace _PhpScopera143bcca66cb\phpDocumentor\Reflection\PseudoTypes;

use _PhpScopera143bcca66cb\phpDocumentor\Reflection\PseudoType;
use _PhpScopera143bcca66cb\phpDocumentor\Reflection\Type;
use _PhpScopera143bcca66cb\phpDocumentor\Reflection\Types\Boolean;
use function class_alias;
/**
 * Value Object representing the PseudoType 'False', which is a Boolean type.
 *
 * @psalm-immutable
 */
final class False_ extends \_PhpScopera143bcca66cb\phpDocumentor\Reflection\Types\Boolean implements \_PhpScopera143bcca66cb\phpDocumentor\Reflection\PseudoType
{
    public function underlyingType() : \_PhpScopera143bcca66cb\phpDocumentor\Reflection\Type
    {
        return new \_PhpScopera143bcca66cb\phpDocumentor\Reflection\Types\Boolean();
    }
    public function __toString() : string
    {
        return 'false';
    }
}
\class_alias('_PhpScopera143bcca66cb\\phpDocumentor\\Reflection\\PseudoTypes\\False_', '_PhpScopera143bcca66cb\\phpDocumentor\\Reflection\\Types\\False_', \false);
