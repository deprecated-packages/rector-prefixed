<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\RectorGenerator\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Option;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
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
            $propertyName = \_PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings::uppercaseUnderscoreToCamelCase($constantName);
            $type = new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
            $property = $this->nodeFactory->createPrivatePropertyFromNameAndType($propertyName, $type);
            $property->props[0]->default = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_([]);
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
    public function createConfigureClassMethod(array $ruleConfiguration) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $this->lowerPhpVersion();
        $classMethod = $this->nodeFactory->createPublicMethod('configure');
        $classMethod->returnType = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier('void');
        $configurationVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('configuration');
        $configurationParam = new \_PhpScoperb75b35f52b74\PhpParser\Node\Param($configurationVariable);
        $configurationParam->type = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier('array');
        $classMethod->params[] = $configurationParam;
        $assigns = [];
        foreach (\array_keys($ruleConfiguration) as $constantName) {
            $coalesce = $this->createConstantInConfigurationCoalesce($constantName, $configurationVariable);
            $propertyName = \_PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings::uppercaseUnderscoreToCamelCase($constantName);
            $assign = $this->nodeFactory->createPropertyAssignmentWithExpr($propertyName, $coalesce);
            $assigns[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($assign);
        }
        $classMethod->stmts = $assigns;
        $phpDocInfo = $this->phpDocInfoFactory->createEmpty($classMethod);
        $identifierTypeNode = new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('mixed[]');
        $paramTagValueNode = new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode($identifierTypeNode, \false, '$configuration', '');
        $phpDocInfo->addTagValueNode($paramTagValueNode);
        return $classMethod;
    }
    /**
     * So types are PHP 7.2 compatible
     */
    private function lowerPhpVersion() : void
    {
        $this->parameterProvider->changeParameter(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES - 1);
    }
    private function createConstantInConfigurationCoalesce(string $constantName, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $configurationVariable) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce
    {
        $classConstFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('self'), $constantName);
        $arrayDimFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch($configurationVariable, $classConstFetch);
        $emptyArray = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_([]);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce($arrayDimFetch, $emptyArray);
    }
}
