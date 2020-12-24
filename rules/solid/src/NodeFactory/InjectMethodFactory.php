<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\SOLID\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ParamBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoperb75b35f52b74\Rector\PhpAttribute\ValueObject\TagName;
use _PhpScoperb75b35f52b74\Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \_PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
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
    public function createFromTypes(array $objectTypes, string $className, string $framework) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $objectTypes = $this->typeFactory->uniquateTypes($objectTypes);
        $shortClassName = $this->classNaming->getShortName($className);
        $methodBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder('inject' . $shortClassName);
        $methodBuilder->makePublic();
        foreach ($objectTypes as $objectType) {
            /** @var ObjectType $objectType */
            $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
            $paramBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ParamBuilder($propertyName);
            $paramBuilder->setType(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($objectType->getClassName()));
            $methodBuilder->addParam($paramBuilder);
            $assign = $this->nodeFactory->createPropertyAssignment($propertyName);
            $methodBuilder->addStmt($assign);
        }
        $classMethod = $methodBuilder->getNode();
        if ($framework === \_PhpScoperb75b35f52b74\Rector\SOLID\Rector\Class_\MultiParentingToAbstractDependencyRector::FRAMEWORK_SYMFONY) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($classMethod);
            $phpDocInfo->addBareTag(\_PhpScoperb75b35f52b74\Rector\PhpAttribute\ValueObject\TagName::REQUIRED);
        }
        return $classMethod;
    }
}
