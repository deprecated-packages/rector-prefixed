<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector;

use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
/**
 * This interface is used to ensure a reflector implements these basic methods.
 */
interface Reflector
{
    /**
     * Create a reflection from the named identifier.
     *
     * @throws IdentifierNotFound
     */
    public function reflect(string $identifierName) : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
}
