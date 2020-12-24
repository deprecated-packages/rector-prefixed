<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection;

use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PhpParser\Node\UnionType;
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
        if ($type instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType) {
            $type = $type->type;
            $allowsNull = \true;
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier || $type instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            return new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionNamedType($type, $allowsNull);
        }
        return new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionUnionType($type, $allowsNull);
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
