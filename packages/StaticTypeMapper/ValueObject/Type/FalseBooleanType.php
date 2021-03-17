<?php

declare (strict_types=1);
namespace Rector\StaticTypeMapper\ValueObject\Type;

use PHPStan\Type\BooleanType;
use PHPStan\Type\VerbosityLevel;
/**
 * Special case for union types
 * @see https://wiki.php.net/rfc/union_types_v2#false_pseudo-type
 */
final class FalseBooleanType extends \PHPStan\Type\BooleanType
{
    /**
     * @param \PHPStan\Type\VerbosityLevel $verbosityLevel
     */
    public function describe($verbosityLevel) : string
    {
        return 'false';
    }
}
