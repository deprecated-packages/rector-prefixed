<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier;

use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Exception\InvalidIdentifierName;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract;
use function ltrim;
use function preg_match;
use function strpos;
class Identifier
{
    public const WILDCARD = '*';
    private const VALID_NAME_REGEXP = '/([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*)(\\\\[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*)*/';
    /** @var string */
    private $name;
    /** @var IdentifierType */
    private $type;
    /**
     * @throws InvalidIdentifierName
     */
    public function __construct(string $name, \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType $type)
    {
        $this->type = $type;
        if ($name === self::WILDCARD || $name === \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract::CLOSURE_NAME || \strpos($name, \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass::ANONYMOUS_CLASS_NAME_PREFIX) === 0) {
            $this->name = $name;
            return;
        }
        $name = \ltrim($name, '\\');
        if (!\preg_match(self::VALID_NAME_REGEXP, $name)) {
            throw \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Exception\InvalidIdentifierName::fromInvalidName($name);
        }
        $this->name = $name;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getType() : \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType
    {
        return $this->type;
    }
    public function isClass() : bool
    {
        return $this->type->isClass();
    }
    public function isFunction() : bool
    {
        return $this->type->isFunction();
    }
    public function isConstant() : bool
    {
        return $this->type->isConstant();
    }
}
