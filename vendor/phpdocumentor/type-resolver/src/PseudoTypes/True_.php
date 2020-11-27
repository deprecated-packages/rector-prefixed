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
namespace _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\PseudoTypes;

use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\PseudoType;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Type;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Types\Boolean;
use function class_alias;
/**
 * Value Object representing the PseudoType 'False', which is a Boolean type.
 *
 * @psalm-immutable
 */
final class True_ extends \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Types\Boolean implements \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\PseudoType
{
    public function underlyingType() : \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Type
    {
        return new \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Types\Boolean();
    }
    public function __toString() : string
    {
        return 'true';
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\phpDocumentor\\Reflection\\PseudoTypes\\True_', '_PhpScoperbd5d0c5f7638\\phpDocumentor\\Reflection\\Types\\True_', \false);
