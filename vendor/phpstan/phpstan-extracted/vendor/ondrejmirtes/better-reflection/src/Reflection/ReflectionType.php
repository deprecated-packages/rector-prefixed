<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\NullableType;
use _PhpScoper0a2ac50786fa\PhpParser\Node\UnionType;
abstract class ReflectionType
{
    /** @var bool */
    private $allowsNull;
    protected function __construct(bool $allowsNull)
    {
        $this->allowsNull = $allowsNull;
    }
    /**
     * @param Identifier|Name|NullableType|UnionType $type
     */
    public static function createFromTypeAndReflector($type) : self
    {
        $allowsNull = \false;
        if ($type instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\NullableType) {
            $type = $type->type;
            $allowsNull = \true;
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier || $type instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
            return new \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionNamedType($type, $allowsNull);
        }
        return new \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionUnionType($type, $allowsNull);
    }
    /**
     * Does the parameter allow null?
     */
    public function allowsNull() : bool
    {
        return $this->allowsNull;
    }
    /**
     * Convert this string type to a string
     */
    public abstract function __toString() : string;
}
