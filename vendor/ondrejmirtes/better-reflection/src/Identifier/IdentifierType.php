<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Roave\BetterReflection\Identifier;

use InvalidArgumentException;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\ReflectionClass;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\ReflectionConstant;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\ReflectionFunction;
use function array_key_exists;
use function sprintf;
class IdentifierType
{
    public const IDENTIFIER_CLASS = \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\ReflectionClass::class;
    public const IDENTIFIER_FUNCTION = \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\ReflectionFunction::class;
    public const IDENTIFIER_CONSTANT = \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\ReflectionConstant::class;
    private const VALID_TYPES = [self::IDENTIFIER_CLASS => null, self::IDENTIFIER_FUNCTION => null, self::IDENTIFIER_CONSTANT => null];
    /** @var string */
    private $name;
    public function __construct(string $type = self::IDENTIFIER_CLASS)
    {
        if (!\array_key_exists($type, self::VALID_TYPES)) {
            throw new \InvalidArgumentException(\sprintf('%s is not a valid identifier type', $type));
        }
        $this->name = $type;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function isClass() : bool
    {
        return $this->name === self::IDENTIFIER_CLASS;
    }
    public function isFunction() : bool
    {
        return $this->name === self::IDENTIFIER_FUNCTION;
    }
    public function isConstant() : bool
    {
        return $this->name === self::IDENTIFIER_CONSTANT;
    }
    /**
     * Check to see if a reflector is of a valid type specified by this identifier.
     */
    public function isMatchingReflector(\_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\Reflection $reflector) : bool
    {
        if ($this->name === self::IDENTIFIER_CLASS) {
            return $reflector instanceof \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\ReflectionClass;
        }
        if ($this->name === self::IDENTIFIER_FUNCTION) {
            return $reflector instanceof \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\ReflectionFunction;
        }
        if ($this->name === self::IDENTIFIER_CONSTANT) {
            return $reflector instanceof \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\ReflectionConstant;
        }
        return \false;
    }
}
