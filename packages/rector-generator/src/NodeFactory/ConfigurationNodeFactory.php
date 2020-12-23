<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\RectorGenerator\NodeFactory;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoper0a2ac50786fa\Rector\Core\Util\StaticRectorStrings;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
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
            $propertyName = \_PhpScoper0a2ac50786fa\Rector\Core\Util\StaticRectorStrings::uppercaseUnderscoreToCamelCase($constantName);
            $type = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType());
            $property = $this->nodeFactory->createPrivatePropertyFromNameAndType($propertyName, $type);
            $property->props[0]->default = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_([]);
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
    public function createConfigureClassMethod(array $ruleConfiguration) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod
    {
        $this->lowerPhpVersion();
        $classMethod = $this->nodeFactory->createPublicMethod('configure');
        $classMethod->returnType = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier('void');
        $configurationVariable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('configuration');
        $configurationParam = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Param($configurationVariable);
        $configurationParam->type = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier('array');
        $classMethod->params[] = $configurationParam;
        $assigns = [];
        foreach (\array_keys($ruleConfiguration) as $constantName) {
            $coalesce = $this->createConstantInConfigurationCoalesce($constantName, $configurationVariable);
            $propertyName = \_PhpScoper0a2ac50786fa\Rector\Core\Util\StaticRectorStrings::uppercaseUnderscoreToCamelCase($constantName);
            $assign = $this->nodeFactory->createPropertyAssignmentWithExpr($propertyName, $coalesce);
            $assigns[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($assign);
        }
        $classMethod->stmts = $assigns;
        $phpDocInfo = $this->phpDocInfoFactory->createEmpty($classMethod);
        $identifierTypeNode = new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('mixed[]');
        $paramTagValueNode = new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode($identifierTypeNode, \false, '$configuration', '');
        $phpDocInfo->addTagValueNode($paramTagValueNode);
        return $classMethod;
    }
    /**
     * So types are PHP 7.2 compatible
     */
    private function lowerPhpVersion() : void
    {
        $this->parameterProvider->changeParameter(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES - 1);
    }
    private function createConstantInConfigurationCoalesce(string $constantName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $configurationVariable) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Coalesce
    {
        $classConstFetch = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('self'), $constantName);
        $arrayDimFetch = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch($configurationVariable, $classConstFetch);
        $emptyArray = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_([]);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Coalesce($arrayDimFetch, $emptyArray);
    }
}
