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
namespace _PhpScoper88fe6e0ad041\phpDocumentor\Reflection\PseudoTypes;

use _PhpScoper88fe6e0ad041\phpDocumentor\Reflection\PseudoType;
use _PhpScoper88fe6e0ad041\phpDocumentor\Reflection\Type;
use _PhpScoper88fe6e0ad041\phpDocumentor\Reflection\Types\Boolean;
use function class_alias;
/**
 * Value Object representing the PseudoType 'False', which is a Boolean type.
 *
 * @psalm-immutable
 */
final class False_ extends \_PhpScoper88fe6e0ad041\phpDocumentor\Reflection\Types\Boolean implements \_PhpScoper88fe6e0ad041\phpDocumentor\Reflection\PseudoType
{
    public function underlyingType() : \_PhpScoper88fe6e0ad041\phpDocumentor\Reflection\Type
    {
        return new \_PhpScoper88fe6e0ad041\phpDocumentor\Reflection\Types\Boolean();
    }
    public function __toString() : string
    {
        return 'false';
    }
}
\class_alias('_PhpScoper88fe6e0ad041\\phpDocumentor\\Reflection\\PseudoTypes\\False_', '_PhpScoper88fe6e0ad041\\phpDocumentor\\Reflection\\Types\\False_', \false);
