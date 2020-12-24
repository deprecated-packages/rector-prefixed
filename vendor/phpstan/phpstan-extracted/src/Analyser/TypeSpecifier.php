<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Analyser;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\LogicalOr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Instanceof_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a6b37af0871\PHPStan\Type\Accessory\HasOffsetType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Accessory\HasPropertyType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ConstantType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NeverType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NonexistentParentClassType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StaticType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StaticTypeFactory;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeTraverser;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use function array_reverse;
class TypeSpecifier
{
    /** @var \PhpParser\PrettyPrinter\Standard */
    private $printer;
    /** @var ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Type\FunctionTypeSpecifyingExtension[] */
    private $functionTypeSpecifyingExtensions;
    /** @var \PHPStan\Type\MethodTypeSpecifyingExtension[] */
    private $methodTypeSpecifyingExtensions;
    /** @var \PHPStan\Type\StaticMethodTypeSpecifyingExtension[] */
    private $staticMethodTypeSpecifyingExtensions;
    /** @var \PHPStan\Type\MethodTypeSpecifyingExtension[][]|null */
    private $methodTypeSpecifyingExtensionsByClass = null;
    /** @var \PHPStan\Type\StaticMethodTypeSpecifyingExtension[][]|null */
    private $staticMethodTypeSpecifyingExtensionsByClass = null;
    /**
     * @param \PhpParser\PrettyPrinter\Standard $printer
     * @param ReflectionProvider $reflectionProvider
     * @param \PHPStan\Type\FunctionTypeSpecifyingExtension[] $functionTypeSpecifyingExtensions
     * @param \PHPStan\Type\MethodTypeSpecifyingExtension[] $methodTypeSpecifyingExtensions
     * @param \PHPStan\Type\StaticMethodTypeSpecifyingExtension[] $staticMethodTypeSpecifyingExtensions
     */
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\PrettyPrinter\Standard $printer, \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $functionTypeSpecifyingExtensions, array $methodTypeSpecifyingExtensions, array $staticMethodTypeSpecifyingExtensions)
    {
        $this->printer = $printer;
        $this->reflectionProvider = $reflectionProvider;
        foreach (\array_merge($functionTypeSpecifyingExtensions, $methodTypeSpecifyingExtensions, $staticMethodTypeSpecifyingExtensions) as $extension) {
            if (!$extension instanceof \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierAwareExtension) {
                continue;
            }
            $extension->setTypeSpecifier($this);
        }
        $this->functionTypeSpecifyingExtensions = $functionTypeSpecifyingExtensions;
        $this->methodTypeSpecifyingExtensions = $methodTypeSpecifyingExtensions;
        $this->staticMethodTypeSpecifyingExtensions = $staticMethodTypeSpecifyingExtensions;
    }
    public function specifyTypesInCondition(\_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context, bool $defaultHandleFunctions = \false) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes
    {
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Instanceof_) {
            $exprNode = $expr->expr;
            if ($exprNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
                $exprNode = $exprNode->var;
            }
            if ($expr->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
                $className = (string) $expr->class;
                $lowercasedClassName = \strtolower($className);
                if ($lowercasedClassName === 'self' && $scope->isInClass()) {
                    $type = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($scope->getClassReflection()->getName());
                } elseif ($lowercasedClassName === 'static' && $scope->isInClass()) {
                    $type = new \_PhpScoper0a6b37af0871\PHPStan\Type\StaticType($scope->getClassReflection()->getName());
                } elseif ($lowercasedClassName === 'parent') {
                    if ($scope->isInClass() && $scope->getClassReflection()->getParentClass() !== \false) {
                        $type = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($scope->getClassReflection()->getParentClass()->getName());
                    } else {
                        $type = new \_PhpScoper0a6b37af0871\PHPStan\Type\NonexistentParentClassType();
                    }
                } else {
                    $type = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($className);
                }
                return $this->create($exprNode, $type, $context);
            }
            $classType = $scope->getType($expr->class);
            $type = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeTraverser::map($classType, static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, callable $traverse) : Type {
                if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType || $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType) {
                    return $traverse($type);
                }
                if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
                    return $type;
                }
                if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericClassStringType) {
                    return $type->getGenericType();
                }
                if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
                    return new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($type->getValue());
                }
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
            });
            if (!$type->isSuperTypeOf(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType())->yes()) {
                if ($context->true()) {
                    $type = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::intersect($type, new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType());
                }
                return $this->create($exprNode, $type, $context);
            }
            if ($context->true()) {
                return $this->create($exprNode, new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType(), $context);
            }
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical) {
            $expressions = $this->findTypeExpressionsFromBinaryOperation($scope, $expr);
            if ($expressions !== null) {
                /** @var Expr $exprNode */
                $exprNode = $expressions[0];
                if ($exprNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
                    $exprNode = $exprNode->var;
                }
                /** @var \PHPStan\Type\ConstantScalarType $constantType */
                $constantType = $expressions[1];
                if ($constantType->getValue() === \false) {
                    $types = $this->create($exprNode, $constantType, $context);
                    return $types->unionWith($this->specifyTypesInCondition($scope, $exprNode, $context->true() ? \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createFalse() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createFalse()->negate()));
                }
                if ($constantType->getValue() === \true) {
                    $types = $this->create($exprNode, $constantType, $context);
                    return $types->unionWith($this->specifyTypesInCondition($scope, $exprNode, $context->true() ? \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createTrue() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createTrue()->negate()));
                }
                if ($constantType->getValue() === null) {
                    return $this->create($exprNode, $constantType, $context);
                }
                if (!$context->null() && $exprNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall && \count($exprNode->args) === 1 && $exprNode->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name && \strtolower((string) $exprNode->name) === 'count' && $constantType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType) {
                    if ($context->truthy() || $constantType->getValue() === 0) {
                        $newContext = $context;
                        if ($constantType->getValue() === 0) {
                            $newContext = $newContext->negate();
                        }
                        $argType = $scope->getType($exprNode->args[0]->value);
                        if ((new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType()))->isSuperTypeOf($argType)->yes()) {
                            return $this->create($exprNode->args[0]->value, new \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\NonEmptyArrayType(), $newContext);
                        }
                    }
                }
            }
            if ($context->true()) {
                $type = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::intersect($scope->getType($expr->right), $scope->getType($expr->left));
                $leftTypes = $this->create($expr->left, $type, $context);
                $rightTypes = $this->create($expr->right, $type, $context);
                return $leftTypes->unionWith($rightTypes);
            } elseif ($context->false()) {
                $identicalType = $scope->getType($expr);
                if ($identicalType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType) {
                    $never = new \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType();
                    $contextForTypes = $identicalType->getValue() ? $context->negate() : $context;
                    $leftTypes = $this->create($expr->left, $never, $contextForTypes);
                    $rightTypes = $this->create($expr->right, $never, $contextForTypes);
                    return $leftTypes->unionWith($rightTypes);
                }
                $exprLeftType = $scope->getType($expr->left);
                $exprRightType = $scope->getType($expr->right);
                $types = null;
                if ($exprLeftType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantType && !$expr->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar) {
                    $types = $this->create($expr->right, $exprLeftType, $context);
                }
                if ($exprRightType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantType && !$expr->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar) {
                    $leftType = $this->create($expr->left, $exprRightType, $context);
                    if ($types !== null) {
                        $types = $types->unionWith($leftType);
                    } else {
                        $types = $leftType;
                    }
                }
                if ($types !== null) {
                    return $types;
                }
            }
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return $this->specifyTypesInCondition($scope, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical($expr->left, $expr->right)), $context);
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Equal) {
            $expressions = $this->findTypeExpressionsFromBinaryOperation($scope, $expr);
            if ($expressions !== null) {
                /** @var Expr $exprNode */
                $exprNode = $expressions[0];
                /** @var \PHPStan\Type\ConstantScalarType $constantType */
                $constantType = $expressions[1];
                if ($constantType->getValue() === \false || $constantType->getValue() === null) {
                    return $this->specifyTypesInCondition($scope, $exprNode, $context->true() ? \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createFalsey() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createFalsey()->negate());
                }
                if ($constantType->getValue() === \true) {
                    return $this->specifyTypesInCondition($scope, $exprNode, $context->true() ? \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createTruthy() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createTruthy()->negate());
                }
            }
            $leftType = $scope->getType($expr->left);
            $leftBooleanType = $leftType->toBoolean();
            $rightType = $scope->getType($expr->right);
            if ($leftBooleanType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType && $rightType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType) {
                return $this->specifyTypesInCondition($scope, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name($leftBooleanType->getValue() ? 'true' : 'false')), $expr->right), $context);
            }
            $rightBooleanType = $rightType->toBoolean();
            if ($rightBooleanType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType && $leftType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType) {
                return $this->specifyTypesInCondition($scope, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical($expr->left, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name($rightBooleanType->getValue() ? 'true' : 'false'))), $context);
            }
            if ($expr->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall && $expr->left->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name && \strtolower($expr->left->name->toString()) === 'get_class' && isset($expr->left->args[0]) && $rightType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
                return $this->specifyTypesInCondition($scope, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Instanceof_($expr->left->args[0]->value, new \_PhpScoper0a6b37af0871\PhpParser\Node\Name($rightType->getValue())), $context);
            }
            if ($expr->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall && $expr->right->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name && \strtolower($expr->right->name->toString()) === 'get_class' && isset($expr->right->args[0]) && $leftType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
                return $this->specifyTypesInCondition($scope, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Instanceof_($expr->right->args[0]->value, new \_PhpScoper0a6b37af0871\PhpParser\Node\Name($leftType->getValue())), $context);
            }
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotEqual) {
            return $this->specifyTypesInCondition($scope, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Equal($expr->left, $expr->right)), $context);
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Smaller || $expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual) {
            $offset = $expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Smaller ? 1 : 0;
            $leftType = $scope->getType($expr->left);
            $rightType = $scope->getType($expr->right);
            if ($expr->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall && \count($expr->left->args) === 1 && $expr->left->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name && \strtolower((string) $expr->left->name) === 'count' && $rightType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType) {
                $inverseOperator = $expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Smaller ? new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual($expr->right, $expr->left) : new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Smaller($expr->right, $expr->left);
                return $this->specifyTypesInCondition($scope, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot($inverseOperator), $context);
            }
            $result = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes();
            if (!$context->null() && $expr->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall && \count($expr->right->args) === 1 && $expr->right->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name && \strtolower((string) $expr->right->name) === 'count' && $leftType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType) {
                if ($context->truthy() || $leftType->getValue() + $offset === 1) {
                    $argType = $scope->getType($expr->right->args[0]->value);
                    if ((new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType()))->isSuperTypeOf($argType)->yes()) {
                        $result = $result->unionWith($this->create($expr->right->args[0]->value, new \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\NonEmptyArrayType(), $context));
                    }
                }
            }
            if ($leftType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType) {
                if ($expr->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PostInc) {
                    $result = $result->unionWith($this->createRangeTypes($expr->right->var, \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval($leftType->getValue(), null, $offset + 1), $context));
                } elseif ($expr->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PostDec) {
                    $result = $result->unionWith($this->createRangeTypes($expr->right->var, \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval($leftType->getValue(), null, $offset - 1), $context));
                } elseif ($expr->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PreInc || $expr->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PreDec) {
                    $result = $result->unionWith($this->createRangeTypes($expr->right->var, \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval($leftType->getValue(), null, $offset), $context));
                }
                $result = $result->unionWith($this->createRangeTypes($expr->right, \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval($leftType->getValue(), null, $offset), $context));
            }
            if ($rightType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType) {
                if ($expr->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PostInc) {
                    $result = $result->unionWith($this->createRangeTypes($expr->left->var, \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval(null, $rightType->getValue(), -$offset + 1), $context));
                } elseif ($expr->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PostDec) {
                    $result = $result->unionWith($this->createRangeTypes($expr->left->var, \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval(null, $rightType->getValue(), -$offset - 1), $context));
                } elseif ($expr->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PreInc || $expr->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PreDec) {
                    $result = $result->unionWith($this->createRangeTypes($expr->left->var, \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval(null, $rightType->getValue(), -$offset), $context));
                }
                $result = $result->unionWith($this->createRangeTypes($expr->left, \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval(null, $rightType->getValue(), -$offset), $context));
            }
            return $result;
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Greater) {
            return $this->specifyTypesInCondition($scope, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Smaller($expr->right, $expr->left), $context, $defaultHandleFunctions);
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual) {
            return $this->specifyTypesInCondition($scope, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual($expr->right, $expr->left), $context, $defaultHandleFunctions);
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall && $expr->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
            if ($this->reflectionProvider->hasFunction($expr->name, $scope)) {
                $functionReflection = $this->reflectionProvider->getFunction($expr->name, $scope);
                foreach ($this->getFunctionTypeSpecifyingExtensions() as $extension) {
                    if (!$extension->isFunctionSupported($functionReflection, $expr, $context)) {
                        continue;
                    }
                    return $extension->specifyTypes($functionReflection, $expr, $scope, $context);
                }
            }
            if ($defaultHandleFunctions) {
                return $this->handleDefaultTruthyOrFalseyContext($context, $expr);
            }
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall && $expr->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier) {
            $methodCalledOnType = $scope->getType($expr->var);
            $referencedClasses = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getDirectClassNames($methodCalledOnType);
            if (\count($referencedClasses) === 1 && $this->reflectionProvider->hasClass($referencedClasses[0])) {
                $methodClassReflection = $this->reflectionProvider->getClass($referencedClasses[0]);
                if ($methodClassReflection->hasMethod($expr->name->name)) {
                    $methodReflection = $methodClassReflection->getMethod($expr->name->name, $scope);
                    foreach ($this->getMethodTypeSpecifyingExtensionsForClass($methodClassReflection->getName()) as $extension) {
                        if (!$extension->isMethodSupported($methodReflection, $expr, $context)) {
                            continue;
                        }
                        return $extension->specifyTypes($methodReflection, $expr, $scope, $context);
                    }
                }
            }
            if ($defaultHandleFunctions) {
                return $this->handleDefaultTruthyOrFalseyContext($context, $expr);
            }
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall && $expr->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier) {
            if ($expr->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
                $calleeType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($scope->resolveName($expr->class));
            } else {
                $calleeType = $scope->getType($expr->class);
            }
            if ($calleeType->hasMethod($expr->name->name)->yes()) {
                $staticMethodReflection = $calleeType->getMethod($expr->name->name, $scope);
                $referencedClasses = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getDirectClassNames($calleeType);
                if (\count($referencedClasses) === 1 && $this->reflectionProvider->hasClass($referencedClasses[0])) {
                    $staticMethodClassReflection = $this->reflectionProvider->getClass($referencedClasses[0]);
                    foreach ($this->getStaticMethodTypeSpecifyingExtensionsForClass($staticMethodClassReflection->getName()) as $extension) {
                        if (!$extension->isStaticMethodSupported($staticMethodReflection, $expr, $context)) {
                            continue;
                        }
                        return $extension->specifyTypes($staticMethodReflection, $expr, $scope, $context);
                    }
                }
            }
            if ($defaultHandleFunctions) {
                return $this->handleDefaultTruthyOrFalseyContext($context, $expr);
            }
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd || $expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\LogicalAnd) {
            $leftTypes = $this->specifyTypesInCondition($scope, $expr->left, $context);
            $rightTypes = $this->specifyTypesInCondition($scope, $expr->right, $context);
            return $context->true() ? $leftTypes->unionWith($rightTypes) : $leftTypes->intersectWith($rightTypes);
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanOr || $expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\LogicalOr) {
            $leftTypes = $this->specifyTypesInCondition($scope, $expr->left, $context);
            $rightTypes = $this->specifyTypesInCondition($scope, $expr->right, $context);
            return $context->true() ? $leftTypes->intersectWith($rightTypes) : $leftTypes->unionWith($rightTypes);
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot && !$context->null()) {
            return $this->specifyTypesInCondition($scope, $expr->expr, $context->negate());
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
            if (!$scope instanceof \_PhpScoper0a6b37af0871\PHPStan\Analyser\MutatingScope) {
                throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
            }
            if ($context->null()) {
                return $this->specifyTypesInCondition($scope->exitFirstLevelStatements(), $expr->expr, $context);
            }
            return $this->specifyTypesInCondition($scope->exitFirstLevelStatements(), $expr->var, $context);
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Isset_ && \count($expr->vars) > 0 && $context->true() || $expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Empty_ && $context->false()) {
            $vars = [];
            if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Isset_) {
                $varsToIterate = $expr->vars;
            } else {
                $varsToIterate = [$expr->expr];
            }
            foreach ($varsToIterate as $var) {
                $tmpVars = [$var];
                while ($var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch || $var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch || $var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch && $var->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr) {
                    if ($var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch) {
                        /** @var Expr $var */
                        $var = $var->class;
                    } else {
                        $var = $var->var;
                    }
                    $tmpVars[] = $var;
                }
                $vars = \array_merge($vars, \array_reverse($tmpVars));
            }
            if (\count($vars) === 0) {
                throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
            }
            $types = null;
            foreach ($vars as $var) {
                if ($var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable && \is_string($var->name)) {
                    if ($scope->hasVariableType($var->name)->no()) {
                        return new \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes([], []);
                    }
                }
                if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Isset_) {
                    if ($var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch && $var->dim !== null && !$scope->getType($var->var) instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
                        $type = $this->create($var->var, new \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\HasOffsetType($scope->getType($var->dim)), $context)->unionWith($this->create($var, new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType(), \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createFalse()));
                    } else {
                        $type = $this->create($var, new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType(), \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createFalse());
                    }
                } else {
                    $type = $this->create($var, new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false)]), \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createFalse());
                }
                if ($var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch && $var->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier) {
                    $type = $type->unionWith($this->create($var->var, new \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\HasPropertyType($var->name->toString())]), \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createTruthy()));
                } elseif ($var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch && $var->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr && $var->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\VarLikeIdentifier) {
                    $type = $type->unionWith($this->create($var->class, new \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\HasPropertyType($var->name->toString())]), \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createTruthy()));
                }
                if ($types === null) {
                    $types = $type;
                } else {
                    $types = $types->unionWith($type);
                }
            }
            if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Empty_ && (new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType()))->isSuperTypeOf($scope->getType($expr->expr))->yes()) {
                $types = $types->unionWith($this->create($expr->expr, new \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\NonEmptyArrayType(), $context->negate()));
            }
            return $types;
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Empty_ && $context->truthy() && (new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType()))->isSuperTypeOf($scope->getType($expr->expr))->yes()) {
            return $this->create($expr->expr, new \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\NonEmptyArrayType(), $context->negate());
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ErrorSuppress) {
            return $this->specifyTypesInCondition($scope, $expr->expr, $context, $defaultHandleFunctions);
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\NullsafePropertyFetch && !$context->null()) {
            $types = $this->specifyTypesInCondition($scope, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr->var, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('null'))), new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch($expr->var, $expr->name)), $context, $defaultHandleFunctions);
            $nullSafeTypes = $this->handleDefaultTruthyOrFalseyContext($context, $expr);
            return $context->true() ? $types->unionWith($nullSafeTypes) : $types->intersectWith($nullSafeTypes);
        } elseif (!$context->null()) {
            return $this->handleDefaultTruthyOrFalseyContext($context, $expr);
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes();
    }
    private function handleDefaultTruthyOrFalseyContext(\_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes
    {
        if (!$context->truthy()) {
            $type = \_PhpScoper0a6b37af0871\PHPStan\Type\StaticTypeFactory::truthy();
            return $this->create($expr, $type, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createFalse());
        } elseif (!$context->falsey()) {
            $type = \_PhpScoper0a6b37af0871\PHPStan\Type\StaticTypeFactory::falsey();
            return $this->create($expr, $type, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createFalse());
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes();
    }
    /**
     * @param \PHPStan\Analyser\Scope $scope
     * @param \PhpParser\Node\Expr\BinaryOp $binaryOperation
     * @return (Expr|\PHPStan\Type\ConstantScalarType)[]|null
     */
    private function findTypeExpressionsFromBinaryOperation(\_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp $binaryOperation) : ?array
    {
        $leftType = $scope->getType($binaryOperation->left);
        $rightType = $scope->getType($binaryOperation->right);
        if ($leftType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType && !$binaryOperation->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch && !$binaryOperation->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch) {
            return [$binaryOperation->right, $leftType];
        } elseif ($rightType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType && !$binaryOperation->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch && !$binaryOperation->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch) {
            return [$binaryOperation->left, $rightType];
        }
        return null;
    }
    public function create(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context, bool $overwrite = \false) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes
    {
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_ || $expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Instanceof_) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes();
        }
        $sureTypes = [];
        $sureNotTypes = [];
        $exprString = $this->printer->prettyPrintExpr($expr);
        if ($context->false()) {
            $sureNotTypes[$exprString] = [$expr, $type];
        } elseif ($context->true()) {
            $sureTypes[$exprString] = [$expr, $type];
        }
        $types = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes($sureTypes, $sureNotTypes, $overwrite);
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\NullsafePropertyFetch && !$context->null()) {
            $propertyFetchTypes = $this->create(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch($expr->var, $expr->name), $type, $context);
            if ($context->true() && !\_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::containsNull($type)) {
                $propertyFetchTypes = $propertyFetchTypes->unionWith($this->create($expr->var, new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType(), \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createFalse()));
            } elseif ($context->false() && \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::containsNull($type)) {
                $propertyFetchTypes = $propertyFetchTypes->unionWith($this->create($expr->var, new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType(), \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createFalse()));
            }
            return $types->unionWith($propertyFetchTypes);
        }
        return $types;
    }
    private function createRangeTypes(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes
    {
        $sureNotTypes = [];
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType || $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType) {
            $exprString = $this->printer->prettyPrintExpr($expr);
            if ($context->false()) {
                $sureNotTypes[$exprString] = [$expr, $type];
            } elseif ($context->true()) {
                $inverted = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::remove(new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType(), $type);
                $sureNotTypes[$exprString] = [$expr, $inverted];
            }
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes([], $sureNotTypes);
    }
    /**
     * @return \PHPStan\Type\FunctionTypeSpecifyingExtension[]
     */
    private function getFunctionTypeSpecifyingExtensions() : array
    {
        return $this->functionTypeSpecifyingExtensions;
    }
    /**
     * @param string $className
     * @return \PHPStan\Type\MethodTypeSpecifyingExtension[]
     */
    private function getMethodTypeSpecifyingExtensionsForClass(string $className) : array
    {
        if ($this->methodTypeSpecifyingExtensionsByClass === null) {
            $byClass = [];
            foreach ($this->methodTypeSpecifyingExtensions as $extension) {
                $byClass[$extension->getClass()][] = $extension;
            }
            $this->methodTypeSpecifyingExtensionsByClass = $byClass;
        }
        return $this->getTypeSpecifyingExtensionsForType($this->methodTypeSpecifyingExtensionsByClass, $className);
    }
    /**
     * @param string $className
     * @return \PHPStan\Type\StaticMethodTypeSpecifyingExtension[]
     */
    private function getStaticMethodTypeSpecifyingExtensionsForClass(string $className) : array
    {
        if ($this->staticMethodTypeSpecifyingExtensionsByClass === null) {
            $byClass = [];
            foreach ($this->staticMethodTypeSpecifyingExtensions as $extension) {
                $byClass[$extension->getClass()][] = $extension;
            }
            $this->staticMethodTypeSpecifyingExtensionsByClass = $byClass;
        }
        return $this->getTypeSpecifyingExtensionsForType($this->staticMethodTypeSpecifyingExtensionsByClass, $className);
    }
    /**
     * @param \PHPStan\Type\MethodTypeSpecifyingExtension[][]|\PHPStan\Type\StaticMethodTypeSpecifyingExtension[][] $extensions
     * @param string $className
     * @return mixed[]
     */
    private function getTypeSpecifyingExtensionsForType(array $extensions, string $className) : array
    {
        $extensionsForClass = [[]];
        $class = $this->reflectionProvider->getClass($className);
        foreach (\array_merge([$className], $class->getParentClassesNames(), $class->getNativeReflection()->getInterfaceNames()) as $extensionClassName) {
            if (!isset($extensions[$extensionClassName])) {
                continue;
            }
            $extensionsForClass[] = $extensions[$extensionClassName];
        }
        return \array_merge(...$extensionsForClass);
    }
}
