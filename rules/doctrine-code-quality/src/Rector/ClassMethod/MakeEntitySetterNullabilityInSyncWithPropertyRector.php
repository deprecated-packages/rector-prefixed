<?php

declare (strict_types=1);
namespace Rector\DoctrineCodeQuality\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ManyToOneTagValueNode;
use Rector\Core\Rector\AbstractRector;
use Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
use Rector\DoctrineCodeQuality\NodeAnalyzer\SetterClassMethodAnalyzer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://www.luzanky.cz/ for sponsoring this rule
 *
 * @see related to maker bundle https://symfony.com/doc/current/bundles/SymfonyMakerBundle/index.html
 *
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\ClassMethod\MakeEntitySetterNullabilityInSyncWithPropertyRector\MakeEntitySetterNullabilityInSyncWithPropertyRectorTest
 */
final class MakeEntitySetterNullabilityInSyncWithPropertyRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var SetterClassMethodAnalyzer
     */
    private $setterClassMethodAnalyzer;
    /**
     * @var DoctrineDocBlockResolver
     */
    private $doctrineDocBlockResolver;
    public function __construct(\Rector\DoctrineCodeQuality\NodeAnalyzer\SetterClassMethodAnalyzer $setterClassMethodAnalyzer, \Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver)
    {
        $this->setterClassMethodAnalyzer = $setterClassMethodAnalyzer;
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make nullability in setter class method with respect to property', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Product
{
    /**
     * @ORM\ManyToOne(targetEntity="AnotherEntity")
     */
    private $anotherEntity;

    public function setAnotherEntity(?AnotherEntity $anotherEntity)
    {
        $this->anotherEntity = $anotherEntity;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Product
{
    /**
     * @ORM\ManyToOne(targetEntity="AnotherEntity")
     */
    private $anotherEntity;

    public function setAnotherEntity(AnotherEntity $anotherEntity)
    {
        $this->anotherEntity = $anotherEntity;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        // is setter in doctrine?
        if (!$this->doctrineDocBlockResolver->isInDoctrineEntityClass($node)) {
            return null;
        }
        $property = $this->setterClassMethodAnalyzer->matchNullalbeClassMethodProperty($node);
        if (!$property instanceof \PhpParser\Node\Stmt\Property) {
            return null;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        $manyToOneTagValueNode = $phpDocInfo->getByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ManyToOneTagValueNode::class);
        if (!$manyToOneTagValueNode instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ManyToOneTagValueNode) {
            return null;
        }
        $param = $node->params[0];
        /** @var NullableType $paramType */
        $paramType = $param->type;
        $param->type = $paramType->type;
        return $node;
    }
}
