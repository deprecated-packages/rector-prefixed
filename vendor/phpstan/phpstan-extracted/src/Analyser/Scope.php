<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Analyser;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
interface Scope extends \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer
{
    public function getFile() : string;
    public function getFileDescription() : string;
    public function isDeclareStrictTypes() : bool;
    public function isInTrait() : bool;
    public function getTraitReflection() : ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
    /**
     * @return \PHPStan\Reflection\FunctionReflection|\PHPStan\Reflection\MethodReflection|null
     */
    public function getFunction();
    public function getFunctionName() : ?string;
    public function getNamespace() : ?string;
    public function getParentScope() : ?self;
    public function hasVariableType(string $variableName) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function getVariableType(string $variableName) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    /**
     * @return array<int, string>
     */
    public function getDefinedVariables() : array;
    public function hasConstant(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $name) : bool;
    public function isInAnonymousFunction() : bool;
    public function getAnonymousFunctionReflection() : ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor;
    public function getAnonymousFunctionReturnType() : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function getType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    /**
     * Gets type of an expression with no regards to phpDocs.
     * Works for function/method parameters only.
     *
     * @internal
     * @param Expr $expr
     * @return Type
     */
    public function getNativeType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function doNotTreatPhpDocTypesAsCertain() : self;
    public function resolveName(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $name) : string;
    /**
     * @param mixed $value
     */
    public function getTypeFromValue($value) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function isSpecified(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $node) : bool;
    public function isInClassExists(string $className) : bool;
    public function isInClosureBind() : bool;
    public function isParameterValueNullable(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $parameter) : bool;
    /**
     * @param \PhpParser\Node\Name|\PhpParser\Node\Identifier|\PhpParser\Node\NullableType|\PhpParser\Node\UnionType|null $type
     * @param bool $isNullable
     * @param bool $isVariadic
     * @return Type
     */
    public function getFunctionType($type, bool $isNullable, bool $isVariadic) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function isInExpressionAssign(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool;
    public function filterByTruthyValue(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr, bool $defaultHandleFunctions = \false) : self;
    public function filterByFalseyValue(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr, bool $defaultHandleFunctions = \false) : self;
    public function isInFirstLevelStatement() : bool;
}
