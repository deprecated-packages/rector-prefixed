<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector;

use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
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
    public function reflect(string $identifierName) : \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
}
