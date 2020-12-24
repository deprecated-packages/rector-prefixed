<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeHelper;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeTraverser;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
class MissingTypehintCheck
{
    public const TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP = "Consider adding something like <fg=cyan>%s<Foo></> to the PHPDoc.\nYou can turn off this check by setting <fg=cyan>checkMissingIterableValueType: false</> in your <fg=cyan>%%configurationFile%%</>.";
    public const TURN_OFF_NON_GENERIC_CHECK_TIP = 'You can turn this off by setting <fg=cyan>checkGenericClassInNonGenericObjectType: false</> in your <fg=cyan>%configurationFile%</>.';
    private const ITERABLE_GENERIC_CLASS_NAMES = [\Traversable::class, \Iterator::class, \IteratorAggregate::class, \Generator::class];
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var bool */
    private $checkMissingIterableValueType;
    /** @var bool */
    private $checkGenericClassInNonGenericObjectType;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $reflectionProvider, bool $checkMissingIterableValueType, bool $checkGenericClassInNonGenericObjectType)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->checkMissingIterableValueType = $checkMissingIterableValueType;
        $this->checkGenericClassInNonGenericObjectType = $checkGenericClassInNonGenericObjectType;
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\Type[]
     */
    public function getIterableTypesWithMissingValueTypehint(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : array
    {
        if (!$this->checkMissingIterableValueType) {
            return [];
        }
        $iterablesWithMissingValueTypehint = [];
        \_PhpScoper0a6b37af0871\PHPStan\Type\TypeTraverser::map($type, function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, callable $traverse) use(&$iterablesWithMissingValueTypehint) : Type {
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType) {
                return $type;
            }
            if ($type->isIterable()->yes()) {
                $iterableValue = $type->getIterableValueType();
                if ($iterableValue instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType && !$iterableValue->isExplicitMixed()) {
                    if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName && !\in_array($type->getClassName(), self::ITERABLE_GENERIC_CLASS_NAMES, \true) && $this->reflectionProvider->hasClass($type->getClassName())) {
                        $classReflection = $this->reflectionProvider->getClass($type->getClassName());
                        if ($classReflection->isGeneric()) {
                            return $type;
                        }
                    }
                    $iterablesWithMissingValueTypehint[] = $type;
                }
                return $type;
            }
            return $traverse($type);
        });
        return $iterablesWithMissingValueTypehint;
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return array<int, array{string, string[]}>
     */
    public function getNonGenericObjectTypesWithGenericClass(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : array
    {
        if (!$this->checkGenericClassInNonGenericObjectType) {
            return [];
        }
        $objectTypes = [];
        \_PhpScoper0a6b37af0871\PHPStan\Type\TypeTraverser::map($type, static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, callable $traverse) use(&$objectTypes) : Type {
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType) {
                $traverse($type);
                return $type;
            }
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType) {
                return $type;
            }
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType) {
                $classReflection = $type->getClassReflection();
                if ($classReflection === null) {
                    return $type;
                }
                if (\in_array($classReflection->getName(), self::ITERABLE_GENERIC_CLASS_NAMES, \true)) {
                    // checked by getIterableTypesWithMissingValueTypehint() already
                    return $type;
                }
                if ($classReflection->isTrait()) {
                    return $type;
                }
                if (!$classReflection->isGeneric()) {
                    return $type;
                }
                $resolvedType = \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($type);
                if (!$resolvedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType) {
                    throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
                }
                $objectTypes[] = [\sprintf('%s %s', $classReflection->isInterface() ? 'interface' : 'class', $classReflection->getDisplayName(\false)), \array_keys($classReflection->getTemplateTypeMap()->getTypes())];
                return $type;
            }
            $traverse($type);
            return $type;
        });
        return $objectTypes;
    }
}
