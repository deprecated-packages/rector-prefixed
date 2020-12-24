<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Naming;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_;
use _PhpScoperb75b35f52b74\PhpParser\Node\UnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper;
final class ExpectedNameResolver
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->propertyNaming = $propertyNaming;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function resolveForParamIfNotYet(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : ?string
    {
        if ($param->type instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\UnionType) {
            return null;
        }
        $expectedName = $this->resolveForParam($param);
        if ($expectedName === null) {
            return null;
        }
        /** @var string $currentName */
        $currentName = $this->nodeNameResolver->getName($param->var);
        if ($currentName === $expectedName) {
            return null;
        }
        if ($this->endsWith($currentName, $expectedName)) {
            return null;
        }
        return $expectedName;
    }
    public function resolveForParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : ?string
    {
        // nothing to verify
        if ($param->type === null) {
            return null;
        }
        $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
        $expectedName = $this->propertyNaming->getExpectedNameFromType($staticType);
        if ($expectedName === null) {
            return null;
        }
        return $expectedName->getName();
    }
    public function resolveForAssignNonNew(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : ?string
    {
        if ($assign->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_) {
            return null;
        }
        if (!$assign->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return null;
        }
        /** @var Variable $variable */
        $variable = $assign->var;
        return $this->nodeNameResolver->getName($variable);
    }
    public function resolveForAssignNew(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : ?string
    {
        if (!$assign->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_) {
            return null;
        }
        if (!$assign->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return null;
        }
        /** @var New_ $new */
        $new = $assign->expr;
        if (!$new->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            return null;
        }
        $className = $this->nodeNameResolver->getName($new->class);
        $fullyQualifiedObjectType = new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($className);
        $expectedName = $this->propertyNaming->getExpectedNameFromType($fullyQualifiedObjectType);
        if ($expectedName === null) {
            return null;
        }
        return $expectedName->getName();
    }
    /**
     * @param MethodCall|StaticCall|FuncCall $expr
     */
    public function resolveForCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : ?string
    {
        if ($this->isDynamicNameCall($expr)) {
            return null;
        }
        $name = $this->nodeNameResolver->getName($expr->name);
        if ($name === null) {
            return null;
        }
        $returnedType = $this->nodeTypeResolver->getStaticType($expr);
        if ($returnedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
            return null;
        }
        if ($returnedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return null;
        }
        $expectedName = $this->propertyNaming->getExpectedNameFromType($returnedType);
        if ($expectedName !== null) {
            return $expectedName->getName();
        }
        // call with args can return different value, so skip there if not sure about the type
        if ($expr->args !== []) {
            return null;
        }
        $expectedNameFromMethodName = $this->propertyNaming->getExpectedNameFromMethodName($name);
        if ($expectedNameFromMethodName !== null) {
            return $expectedNameFromMethodName->getName();
        }
        return null;
    }
    /**
     * @param MethodCall|StaticCall|FuncCall $expr
     */
    public function resolveForForeach(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : ?string
    {
        if ($this->isDynamicNameCall($expr)) {
            return null;
        }
        $name = $this->nodeNameResolver->getName($expr->name);
        if ($name === null) {
            return null;
        }
        $returnedType = $this->nodeTypeResolver->getStaticType($expr);
        if ($returnedType->isIterable()->no()) {
            return null;
        }
        if ($returnedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
            $returnedType = $this->resolveReturnTypeFromArrayType($expr, $returnedType);
            if ($returnedType === null) {
                return null;
            }
        }
        $expectedNameFromType = $this->propertyNaming->getExpectedNameFromType($returnedType);
        if ($expectedNameFromType !== null) {
            return $expectedNameFromType->getSingularized();
        }
        $expectedNameFromMethodName = $this->propertyNaming->getExpectedNameFromMethodName($name);
        if ($expectedNameFromMethodName === null) {
            return null;
        }
        if ($expectedNameFromMethodName->isSingular()) {
            return null;
        }
        return $expectedNameFromMethodName->getSingularized();
    }
    /**
     * Ends with ucname
     * Starts with adjective, e.g. (Post $firstPost, Post $secondPost)
     */
    private function endsWith(string $currentName, string $expectedName) : bool
    {
        $suffixNamePattern = '#\\w+' . \ucfirst($expectedName) . '#';
        return (bool) \_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($currentName, $suffixNamePattern);
    }
    /**
     * @param MethodCall|StaticCall|FuncCall $expr
     */
    private function isDynamicNameCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
            return \true;
        }
        if ($expr->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return \true;
        }
        return $expr->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
    }
    private function resolveReturnTypeFromArrayType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr, \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType $arrayType) : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $parentNode = $expr->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_) {
            return null;
        }
        if (!$arrayType->getItemType() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            return null;
        }
        return $arrayType->getItemType();
    }
}
