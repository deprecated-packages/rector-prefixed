<?php

declare (strict_types=1);
namespace Rector\DowngradePhp72\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Param;
use PHPStan\BetterReflection\Reflection\Adapter\ReflectionParameter;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use Rector\Core\Exception\NotImplementedYetException;
use Rector\StaticTypeMapper\StaticTypeMapper;
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
    public function __construct(\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \RectorPrefix20210317\Symplify\PackageBuilder\Reflection\PrivatesAccessor $privatesAccessor)
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->privatesAccessor = $privatesAccessor;
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
        if ($typeName === 'array') {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
        }
        if ($typeName === 'string') {
            return new \PHPStan\Type\StringType();
        }
        if ($typeName === 'bool') {
            return new \PHPStan\Type\BooleanType();
        }
        if ($typeName === 'int') {
            return new \PHPStan\Type\IntegerType();
        }
        if ($typeName === 'float') {
            return new \PHPStan\Type\FloatType();
        }
        throw new \Rector\Core\Exception\NotImplementedYetException();
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
