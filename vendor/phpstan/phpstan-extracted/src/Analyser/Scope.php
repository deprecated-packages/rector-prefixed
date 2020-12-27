<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Analyser;

use PhpParser\Node\Expr;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptor;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
interface Scope extends \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer
{
    public function getFile() : string;
    public function getFileDescription() : string;
    public function isDeclareStrictTypes() : bool;
    public function isInTrait() : bool;
    public function getTraitReflection() : ?\RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
    /**
     * @return \PHPStan\Reflection\FunctionReflection|\PHPStan\Reflection\MethodReflection|null
     */
    public function getFunction();
    public function getFunctionName() : ?string;
    public function getNamespace() : ?string;
    public function getParentScope() : ?self;
    public function hasVariableType(string $variableName) : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function getVariableType(string $variableName) : \PHPStan\Type\Type;
    /**
     * @return array<int, string>
     */
    public function getDefinedVariables() : array;
    public function hasConstant(\PhpParser\Node\Name $name) : bool;
    public function isInAnonymousFunction() : bool;
    public function getAnonymousFunctionReflection() : ?\RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptor;
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
