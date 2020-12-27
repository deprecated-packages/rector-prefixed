<?php

declare (strict_types=1);
namespace PHPStan\Analyser;

use PhpParser\Node\Expr;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ParametersAcceptor;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
interface Scope extends \PHPStan\Reflection\ClassMemberAccessAnswerer
{
    public function getFile() : string;
    public function getFileDescription() : string;
    public function isDeclareStrictTypes() : bool;
    public function isInTrait() : bool;
    public function getTraitReflection() : ?\PHPStan\Reflection\ClassReflection;
    /**
     * @return \PHPStan\Reflection\FunctionReflection|\PHPStan\Reflection\MethodReflection|null
     */
    public function getFunction();
    public function getFunctionName() : ?string;
    public function getNamespace() : ?string;
    public function getParentScope() : ?self;
    public function hasVariableType(string $variableName) : \PHPStan\TrinaryLogic;
    public function getVariableType(string $variableName) : \PHPStan\Type\Type;
    /**
     * @return array<int, string>
     */
    public function getDefinedVariables() : array;
    public function hasConstant(\PhpParser\Node\Name $name) : bool;
    public function isInAnonymousFunction() : bool;
    public function getAnonymousFunctionReflection() : ?\PHPStan\Reflection\ParametersAcceptor;
    public function getAnonymousFunctionReturnType() : ?\PHPStan\Type\Type;
    public function getType(\PhpParser\Node\Expr $node) : \PHPStan\Type\Type;
    /**
     * Gets type of an expression with no regards to phpDocs.
     * Works for function/method parameters only.
     *
     * @internal
     * @param Expr $expr
     * @return Type
     */
    public function getNativeType(\PhpParser\Node\Expr $expr) : \PHPStan\Type\Type;
    public function doNotTreatPhpDocTypesAsCertain() : self;
    public function resolveName(\PhpParser\Node\Name $name) : string;
    /**
     * @param mixed $value
     */
    public function getTypeFromValue($value) : \PHPStan\Type\Type;
    public function isSpecified(\PhpParser\Node\Expr $node) : bool;
    public function isInClassExists(string $className) : bool;
    public function isInClosureBind() : bool;
    public function isParameterValueNullable(\PhpParser\Node\Param $parameter) : bool;
    /**
     * @param \PhpParser\Node\Name|\PhpParser\Node\Identifier|\PhpParser\Node\NullableType|\PhpParser\Node\UnionType|null $type
     * @param bool $isNullable
     * @param bool $isVariadic
     * @return Type
     */
    public function getFunctionType($type, bool $isNullable, bool $isVariadic) : \PHPStan\Type\Type;
    public function isInExpressionAssign(\PhpParser\Node\Expr $expr) : bool;
    public function filterByTruthyValue(\PhpParser\Node\Expr $expr, bool $defaultHandleFunctions = \false) : self;
    public function filterByFalseyValue(\PhpParser\Node\Expr $expr, bool $defaultHandleFunctions = \false) : self;
    public function isInFirstLevelStatement() : bool;
}
