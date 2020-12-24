<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Analyser;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface Scope extends \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer
{
    public function getFile() : string;
    public function getFileDescription() : string;
    public function isDeclareStrictTypes() : bool;
    public function isInTrait() : bool;
    public function getTraitReflection() : ?\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
    /**
     * @return \PHPStan\Reflection\FunctionReflection|\PHPStan\Reflection\MethodReflection|null
     */
    public function getFunction();
    public function getFunctionName() : ?string;
    public function getNamespace() : ?string;
    public function getParentScope() : ?self;
    public function hasVariableType(string $variableName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function getVariableType(string $variableName) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    /**
     * @return array<int, string>
     */
    public function getDefinedVariables() : array;
    public function hasConstant(\_PhpScopere8e811afab72\PhpParser\Node\Name $name) : bool;
    public function isInAnonymousFunction() : bool;
    public function getAnonymousFunctionReflection() : ?\_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor;
    public function getAnonymousFunctionReturnType() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function getType(\_PhpScopere8e811afab72\PhpParser\Node\Expr $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    /**
     * Gets type of an expression with no regards to phpDocs.
     * Works for function/method parameters only.
     *
     * @internal
     * @param Expr $expr
     * @return Type
     */
    public function getNativeType(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function doNotTreatPhpDocTypesAsCertain() : self;
    public function resolveName(\_PhpScopere8e811afab72\PhpParser\Node\Name $name) : string;
    /**
     * @param mixed $value
     */
    public function getTypeFromValue($value) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function isSpecified(\_PhpScopere8e811afab72\PhpParser\Node\Expr $node) : bool;
    public function isInClassExists(string $className) : bool;
    public function isInClosureBind() : bool;
    public function isParameterValueNullable(\_PhpScopere8e811afab72\PhpParser\Node\Param $parameter) : bool;
    /**
     * @param \PhpParser\Node\Name|\PhpParser\Node\Identifier|\PhpParser\Node\NullableType|\PhpParser\Node\UnionType|null $type
     * @param bool $isNullable
     * @param bool $isVariadic
     * @return Type
     */
    public function getFunctionType($type, bool $isNullable, bool $isVariadic) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function isInExpressionAssign(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool;
    public function filterByTruthyValue(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr, bool $defaultHandleFunctions = \false) : self;
    public function filterByFalseyValue(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr, bool $defaultHandleFunctions = \false) : self;
    public function isInFirstLevelStatement() : bool;
}
