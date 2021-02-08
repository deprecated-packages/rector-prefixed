<?php

declare (strict_types=1);
namespace Rector\RectorGenerator\NodeFactory;

use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\BinaryOp\Coalesce;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\Core\Configuration\Option;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Core\Util\StaticRectorStrings;
use Rector\Core\ValueObject\PhpVersionFeature;
use RectorPrefix20210208\Symplify\PackageBuilder\Parameter\ParameterProvider;
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
    public function __construct(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \RectorPrefix20210208\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
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
            $propertyName = \Rector\Core\Util\StaticRectorStrings::uppercaseUnderscoreToCamelCase($constantName);
            $type = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
            $property = $this->nodeFactory->createPrivatePropertyFromNameAndType($propertyName, $type);
            $property->props[0]->default = new \PhpParser\Node\Expr\Array_([]);
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
            $constantName = \strtoupper($constantName);
            $constantValue = \strtolower($constantName);
            $classConst = $this->nodeFactory->createPublicClassConst($constantName, $constantValue);
            $classConsts[] = $classConst;
        }
        return $classConsts;
    }
    /**
     * @param array<string, mixed> $ruleConfiguration
     */
    public function createConfigureClassMethod(array $ruleConfiguration) : \PhpParser\Node\Stmt\ClassMethod
    {
        $this->lowerPhpVersion();
        $classMethod = $this->nodeFactory->createPublicMethod('configure');
        $classMethod->returnType = new \PhpParser\Node\Identifier('void');
        $configurationVariable = new \PhpParser\Node\Expr\Variable('configuration');
        $configurationParam = new \PhpParser\Node\Param($configurationVariable);
        $configurationParam->type = new \PhpParser\Node\Identifier('array');
        $classMethod->params[] = $configurationParam;
        $assigns = [];
        foreach (\array_keys($ruleConfiguration) as $constantName) {
            $coalesce = $this->createConstantInConfigurationCoalesce($constantName, $configurationVariable);
            $propertyName = \Rector\Core\Util\StaticRectorStrings::uppercaseUnderscoreToCamelCase($constantName);
            $assign = $this->nodeFactory->createPropertyAssignmentWithExpr($propertyName, $coalesce);
            $assigns[] = new \PhpParser\Node\Stmt\Expression($assign);
        }
        $classMethod->stmts = $assigns;
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        $identifierTypeNode = new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('mixed[]');
        $paramTagValueNode = new \PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode($identifierTypeNode, \false, '$configuration', '');
        $phpDocInfo->addTagValueNode($paramTagValueNode);
        return $classMethod;
    }
    /**
     * So types are PHP 7.2 compatible
     */
    private function lowerPhpVersion() : void
    {
        $this->parameterProvider->changeParameter(\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, \Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES - 1);
    }
    private function createConstantInConfigurationCoalesce(string $constantName, \PhpParser\Node\Expr\Variable $configurationVariable) : \PhpParser\Node\Expr\BinaryOp\Coalesce
    {
        $constantName = \strtoupper($constantName);
        $classConstFetch = new \PhpParser\Node\Expr\ClassConstFetch(new \PhpParser\Node\Name('self'), $constantName);
        $arrayDimFetch = new \PhpParser\Node\Expr\ArrayDimFetch($configurationVariable, $classConstFetch);
        $emptyArray = new \PhpParser\Node\Expr\Array_([]);
        return new \PhpParser\Node\Expr\BinaryOp\Coalesce($arrayDimFetch, $emptyArray);
    }
}
