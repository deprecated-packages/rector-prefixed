<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RectorGenerator\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider;
final class ConfigurationNodeFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->nodeFactory = $nodeFactory;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->parameterProvider = $parameterProvider;
    }
    /**
     * @param array<string, mixed> $ruleConfiguration
     * @return Property[]
     */
    public function createProperties(array $ruleConfiguration) : array
    {
        $this->lowerPhpVersion();
        $properties = [];
        foreach (\array_keys($ruleConfiguration) as $constantName) {
            $propertyName = \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::uppercaseUnderscoreToCamelCase($constantName);
            $type = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
            $property = $this->nodeFactory->createPrivatePropertyFromNameAndType($propertyName, $type);
            $property->props[0]->default = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_([]);
            $properties[] = $property;
        }
        return $properties;
    }
    /**
     * @param array<string, mixed> $ruleConfiguration
     * @return ClassConst[]
     */
    public function createConfigurationConstants(array $ruleConfiguration) : array
    {
        $classConsts = [];
        foreach (\array_keys($ruleConfiguration) as $constantName) {
            $constantValue = \strtolower($constantName);
            $classConst = $this->nodeFactory->createPublicClassConst($constantName, $constantValue);
            $classConsts[] = $classConst;
        }
        return $classConsts;
    }
    /**
     * @param array<string, mixed> $ruleConfiguration
     */
    public function createConfigureClassMethod(array $ruleConfiguration) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $this->lowerPhpVersion();
        $classMethod = $this->nodeFactory->createPublicMethod('configure');
        $classMethod->returnType = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('void');
        $configurationVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('configuration');
        $configurationParam = new \_PhpScopere8e811afab72\PhpParser\Node\Param($configurationVariable);
        $configurationParam->type = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('array');
        $classMethod->params[] = $configurationParam;
        $assigns = [];
        foreach (\array_keys($ruleConfiguration) as $constantName) {
            $coalesce = $this->createConstantInConfigurationCoalesce($constantName, $configurationVariable);
            $propertyName = \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::uppercaseUnderscoreToCamelCase($constantName);
            $assign = $this->nodeFactory->createPropertyAssignmentWithExpr($propertyName, $coalesce);
            $assigns[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($assign);
        }
        $classMethod->stmts = $assigns;
        $phpDocInfo = $this->phpDocInfoFactory->createEmpty($classMethod);
        $identifierTypeNode = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('mixed[]');
        $paramTagValueNode = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode($identifierTypeNode, \false, '$configuration', '');
        $phpDocInfo->addTagValueNode($paramTagValueNode);
        return $classMethod;
    }
    /**
     * So types are PHP 7.2 compatible
     */
    private function lowerPhpVersion() : void
    {
        $this->parameterProvider->changeParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, \_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES - 1);
    }
    private function createConstantInConfigurationCoalesce(string $constantName, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $configurationVariable) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Coalesce
    {
        $classConstFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Name('self'), $constantName);
        $arrayDimFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch($configurationVariable, $classConstFetch);
        $emptyArray = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_([]);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Coalesce($arrayDimFetch, $emptyArray);
    }
}
