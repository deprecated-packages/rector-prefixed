<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

class TypeTraverser
{
    /** @var callable(Type $type, callable(Type): Type $traverse): Type */
    private $cb;
    /**
     * Map a Type recursively
     *
     * For every Type instance, the callback can return a new Type, and/or
     * decide to traverse inner types or to ignore them.
     *
     * The following example converts constant strings to objects, while
     * preserving unions and intersections:
     *
     * TypeTraverser::map($type, function (Type $type, callable $traverse): Type {
     *     if ($type instanceof UnionType || $type instanceof IntersectionType) {
     *         // Traverse inner types
     *         return $traverse($type);
     *     }
     *     if ($type instanceof ConstantStringType) {
     *         // Replaces the current type, and don't traverse
     *         return new ObjectType($type->getValue());
     *     }
     *     // Replaces the current type, and don't traverse
     *     return new MixedType();
     * });
     *
     * @param callable(Type $type, callable(Type): Type $traverse): Type $cb
     */
    public static function map(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, callable $cb) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $self = new self($cb);
        return $self->mapInternal($type);
    }
    /** @param callable(Type $type, callable(Type): Type $traverse): Type $cb */
    private function __construct(callable $cb)
    {
        $this->cb = $cb;
    }
    /** @internal */
    public function mapInternal(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return ($this->cb)($type, [$this, 'traverseInternal']);
    }
    /** @internal */
    public function traverseInternal(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $type->traverse([$this, 'mapInternal']);
    }
}
