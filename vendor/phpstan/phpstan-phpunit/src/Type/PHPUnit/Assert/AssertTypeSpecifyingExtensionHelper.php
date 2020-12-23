<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\PHPUnit\Assert;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Instanceof_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType;
class AssertTypeSpecifyingExtensionHelper
{
    /** @var \Closure[] */
    private static $resolvers;
    /**
     * @param string $name
     * @param \PhpParser\Node\Arg[] $args
     * @return bool
     */
    public static function isSupported(string $name, array $args) : bool
    {
        $trimmedName = self::trimName($name);
        $resolvers = self::getExpressionResolvers();
        if (!\array_key_exists($trimmedName, $resolvers)) {
            return \false;
        }
        $resolver = $resolvers[$trimmedName];
        $resolverReflection = new \ReflectionObject($resolver);
        return \count($args) >= \count($resolverReflection->getMethod('__invoke')->getParameters()) - 1;
    }
    private static function trimName(string $name) : string
    {
        if (\strpos($name, 'assert') !== 0) {
            return $name;
        }
        $name = \substr($name, \strlen('assert'));
        if (\strpos($name, 'Not') === 0) {
            return \substr($name, 3);
        }
        if (\strpos($name, 'IsNot') === 0) {
            return 'Is' . \substr($name, 5);
        }
        return $name;
    }
    /**
     * @param TypeSpecifier $typeSpecifier
     * @param Scope $scope
     * @param string $name
     * @param \PhpParser\Node\Arg[] $args $args
     * @return SpecifiedTypes
     */
    public static function specifyTypes(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifier $typeSpecifier, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, string $name, array $args) : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes
    {
        $expression = self::createExpression($scope, $name, $args);
        if ($expression === null) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        return $typeSpecifier->specifyTypesInCondition($scope, $expression, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext::createTruthy());
    }
    /**
     * @param Scope $scope
     * @param string $name
     * @param \PhpParser\Node\Arg[] $args
     * @return \PhpParser\Node\Expr|null
     */
    private static function createExpression(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, string $name, array $args) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        $trimmedName = self::trimName($name);
        $resolvers = self::getExpressionResolvers();
        $resolver = $resolvers[$trimmedName];
        $expression = $resolver($scope, ...$args);
        if ($expression === null) {
            return null;
        }
        if (\strpos($name, 'Not') !== \false) {
            $expression = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot($expression);
        }
        return $expression;
    }
    /**
     * @return \Closure[]
     */
    private static function getExpressionResolvers() : array
    {
        if (self::$resolvers === null) {
            self::$resolvers = ['InstanceOf' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $object) : ?Instanceof_ {
                $classType = $scope->getType($class->value);
                if (!$classType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType) {
                    return null;
                }
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Instanceof_($object->value, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($classType->getValue()));
            }, 'Same' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $expected, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $actual) : Identical {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical($expected->value, $actual->value);
            }, 'True' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $actual) : Identical {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical($actual->value, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('true')));
            }, 'False' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $actual) : Identical {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical($actual->value, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('false')));
            }, 'Null' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $actual) : Identical {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical($actual->value, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('null')));
            }, 'IsArray' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $actual) : FuncCall {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('is_array'), [$actual]);
            }, 'IsBool' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $actual) : FuncCall {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('is_bool'), [$actual]);
            }, 'IsCallable' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $actual) : FuncCall {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('is_callable'), [$actual]);
            }, 'IsFloat' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $actual) : FuncCall {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('is_float'), [$actual]);
            }, 'IsInt' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $actual) : FuncCall {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('is_int'), [$actual]);
            }, 'IsIterable' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $actual) : FuncCall {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('is_iterable'), [$actual]);
            }, 'IsNumeric' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $actual) : FuncCall {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('is_numeric'), [$actual]);
            }, 'IsObject' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $actual) : FuncCall {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('is_object'), [$actual]);
            }, 'IsResource' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $actual) : FuncCall {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('is_resource'), [$actual]);
            }, 'IsString' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $actual) : FuncCall {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('is_string'), [$actual]);
            }, 'IsScalar' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $actual) : FuncCall {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('is_scalar'), [$actual]);
            }, 'InternalType' => function (\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $type, \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg $value) : ?FuncCall {
                $typeType = $scope->getType($type->value);
                if (!$typeType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType) {
                    return null;
                }
                switch ($typeType->getValue()) {
                    case 'numeric':
                        $functionName = 'is_numeric';
                        break;
                    case 'integer':
                    case 'int':
                        $functionName = 'is_int';
                        break;
                    case 'double':
                    case 'float':
                    case 'real':
                        $functionName = 'is_float';
                        break;
                    case 'string':
                        $functionName = 'is_string';
                        break;
                    case 'boolean':
                    case 'bool':
                        $functionName = 'is_bool';
                        break;
                    case 'scalar':
                        $functionName = 'is_scalar';
                        break;
                    case 'null':
                        $functionName = 'is_null';
                        break;
                    case 'array':
                        $functionName = 'is_array';
                        break;
                    case 'object':
                        $functionName = 'is_object';
                        break;
                    case 'resource':
                        $functionName = 'is_resource';
                        break;
                    case 'callable':
                        $functionName = 'is_callable';
                        break;
                    default:
                        return null;
                }
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($functionName), [$value]);
            }];
        }
        return self::$resolvers;
    }
}
