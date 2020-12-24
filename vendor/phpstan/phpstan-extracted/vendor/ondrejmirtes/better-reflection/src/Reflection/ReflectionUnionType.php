<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection;

use _PhpScopere8e811afab72\PhpParser\Node\UnionType;
use function array_map;
use function implode;
class ReflectionUnionType extends \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionType
{
    /** @var ReflectionType[] */
    private $types;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\UnionType $type, bool $allowsNull)
    {
        parent::__construct($allowsNull);
        $this->types = \array_map(static function ($type) : ReflectionType {
            return \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionType::createFromTypeAndReflector($type);
        }, $type->types);
    }
    /**
     * @return ReflectionType[]
     */
    public function getTypes() : array
    {
        return $this->types;
    }
    public function __toString() : string
    {
        return \implode('|', \array_map(static function (\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionType $type) : string {
            return (string) $type;
        }, $this->types));
    }
}
