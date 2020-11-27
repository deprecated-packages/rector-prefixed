<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\Reflector;

use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
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
    public function reflect(string $identifierName) : \_PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Reflection;
}
