<?php

declare (strict_types=1);
namespace Rector\SOLID\NodeFactory;

use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\CodingStyle\Naming\ClassNaming;
use Rector\Core\PhpParser\Builder\MethodBuilder;
use Rector\Core\PhpParser\Builder\ParamBuilder;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Naming\Naming\PropertyNaming;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector;
final class InjectMethodFactory
{
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\Rector\CodingStyle\Naming\ClassNaming $classNaming, \Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \Rector\Naming\Naming\PropertyNaming $propertyNaming, \Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->propertyNaming = $propertyNaming;
        $this->classNaming = $classNaming;
        $this->typeFactory = $typeFactory;
        $this->nodeFactory = $nodeFactory;
    }
    /**
     * @param ObjectType[] $objectTypes
     */
    public function createFromTypes(array $objectTypes, string $className, string $framework) : \PhpParser\Node\Stmt\ClassMethod
    {
        $objectTypes = $this->typeFactory->uniquateTypes($objectTypes);
        $shortClassName = $this->classNaming->getShortName($className);
        $methodBuilder = new \Rector\Core\PhpParser\Builder\MethodBuilder('inject' . $shortClassName);
        $methodBuilder->makePublic();
        foreach ($objectTypes as $objectType) {
            /** @var ObjectType $objectType */
            $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
            $paramBuilder = new \Rector\Core\PhpParser\Builder\ParamBuilder($propertyName);
            $paramBuilder->setType(new \PhpParser\Node\Name\FullyQualified($objectType->getClassName()));
            $methodBuilder->addParam($paramBuilder);
            $assign = $this->nodeFactory->createPropertyAssignment($propertyName);
            $methodBuilder->addStmt($assign);
        }
        $classMethod = $methodBuilder->getNode();
        if ($framework === \Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector::FRAMEWORK_SYMFONY) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($classMethod);
            $phpDocInfo->addBareTag('required');
        }
        return $classMethod;
    }
}
