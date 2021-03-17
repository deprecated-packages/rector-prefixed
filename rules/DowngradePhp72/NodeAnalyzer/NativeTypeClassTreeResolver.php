<?php

declare (strict_types=1);
namespace Rector\DowngradePhp72\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Param;
use PHPStan\BetterReflection\Reflection\Adapter\ReflectionParameter;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\CallableType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\Core\Exception\NotImplementedYetException;
use Rector\StaticTypeMapper\StaticTypeMapper;
use Rector\StaticTypeMapper\ValueObject\Type\SelfObjectType;
use Rector\Tests\DowngradePhp74\Rector\ClassMethod\DowngradeCovariantReturnTypeRector\Fixture\ParentType;
use ReflectionNamedType;
use RectorPrefix20210317\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
final class NativeTypeClassTreeResolver
{
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var PrivatesAccessor
     */
    private $privatesAccessor;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \RectorPrefix20210317\Symplify\PackageBuilder\Reflection\PrivatesAccessor $privatesAccessor, \PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->privatesAccessor = $privatesAccessor;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function resolveParameterReflectionType(\PHPStan\Reflection\ClassReflection $classReflection, string $methodName, int $position) : \PHPStan\Type\Type
    {
        $nativeReflectionClass = $classReflection->getNativeReflection();
        if (!$nativeReflectionClass->hasMethod($methodName)) {
            return new \PHPStan\Type\MixedType();
        }
        $reflectionMethod = $nativeReflectionClass->getMethod($methodName);
        $parameterReflection = $reflectionMethod->getParameters()[$position] ?? null;
        if (!$parameterReflection instanceof \ReflectionParameter) {
            return new \PHPStan\Type\MixedType();
        }
        // "native" reflection from PHPStan removes the type, so we need to check with both reflection and php-paser
        $nativeType = $this->resolveNativeType($parameterReflection);
        if (!$nativeType instanceof \PHPStan\Type\MixedType) {
            return $nativeType;
        }
        if (!$parameterReflection->getType() instanceof \ReflectionNamedType) {
            return new \PHPStan\Type\MixedType();
        }
        $typeName = (string) $parameterReflection->getType();
        $allowsNull = \false;
        if ($parameterReflection->allowsNull()) {
            $allowsNull = \true;
            $typeName = \ltrim($typeName, '?');
        }
        $type = null;
        if ($typeName === 'array') {
            $type = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
        }
        if ($typeName === 'string') {
            $type = new \PHPStan\Type\StringType();
        }
        if ($typeName === 'bool') {
            $type = new \PHPStan\Type\BooleanType();
        }
        if ($typeName === 'int') {
            $type = new \PHPStan\Type\IntegerType();
        }
        if ($typeName === 'float') {
            $type = new \PHPStan\Type\FloatType();
        }
        if ($this->reflectionProvider->hasClass($typeName)) {
            $type = new \PHPStan\Type\ObjectType($typeName);
        }
        if ($type !== null) {
            if ($allowsNull) {
                return new \PHPStan\Type\UnionType([$type, new \PHPStan\Type\NullType()]);
            }
            return $type;
        }
        if ($typeName === 'self') {
            return new \Rector\StaticTypeMapper\ValueObject\Type\SelfObjectType($classReflection->getName(), null, $classReflection);
        }
        if ($typeName === 'object') {
            return new \PHPStan\Type\ObjectWithoutClassType();
        }
        if ($typeName === 'callable') {
            return new \PHPStan\Type\CallableType();
        }
        if ($typeName === 'parent') {
            return new \PHPStan\Type\ObjectType($classReflection->getParentClass()->getName(), null, $classReflection->getParentClass());
        }
        throw new \Rector\Core\Exception\NotImplementedYetException($typeName);
    }
    private function resolveNativeType(\ReflectionParameter $reflectionParameter) : \PHPStan\Type\Type
    {
        if (!$reflectionParameter instanceof \PHPStan\BetterReflection\Reflection\Adapter\ReflectionParameter) {
            return new \PHPStan\Type\MixedType();
        }
        $betterReflectionParameter = $this->privatesAccessor->getPrivateProperty($reflectionParameter, 'betterReflectionParameter');
        $param = $this->privatesAccessor->getPrivateProperty($betterReflectionParameter, 'node');
        if (!$param instanceof \PhpParser\Node\Param) {
            return new \PHPStan\Type\MixedType();
        }
        if (!$param->type instanceof \PhpParser\Node) {
            return new \PHPStan\Type\MixedType();
        }
        return $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
    }
}
