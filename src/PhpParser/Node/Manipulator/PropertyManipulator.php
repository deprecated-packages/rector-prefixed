<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Node\Manipulator;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\PostDec;
use PhpParser\Node\Expr\PostInc;
use PhpParser\Node\Expr\PreDec;
use PhpParser\Node\Expr\PreInc;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\Doctrine\AbstractRector\DoctrineTrait;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\ReadWrite\Guard\VariableToConstantGuard;
use Rector\ReadWrite\NodeAnalyzer\ReadWritePropertyAnalyzer;
/**
 * "private $property"
 */
final class PropertyManipulator
{
    use DoctrineTrait;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var AssignManipulator
     */
    private $assignManipulator;
    /**
     * @var VariableToConstantGuard
     */
    private $variableToConstantGuard;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    /**
     * @var ReadWritePropertyAnalyzer
     */
    private $readWritePropertyAnalyzer;
    public function __construct(\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator $assignManipulator, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\ReadWrite\Guard\VariableToConstantGuard $variableToConstantGuard, \Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \Rector\ReadWrite\NodeAnalyzer\ReadWritePropertyAnalyzer $readWritePropertyAnalyzer)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->assignManipulator = $assignManipulator;
        $this->variableToConstantGuard = $variableToConstantGuard;
        $this->nodeRepository = $nodeRepository;
        $this->readWritePropertyAnalyzer = $readWritePropertyAnalyzer;
    }
    /**
     * @return PropertyFetch[]|StaticPropertyFetch[]
     */
    public function getPrivatePropertyFetches(\PhpParser\Node\Stmt\Property $property) : array
    {
        /** @var Class_|null $classLike */
        $classLike = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return [];
        }
        $nodesToSearch = $this->nodeRepository->findUsedTraitsInClass($classLike);
        $nodesToSearch[] = $classLike;
        $singleProperty = $property->props[0];
        /** @var PropertyFetch[]|StaticPropertyFetch[] $propertyFetches */
        $propertyFetches = $this->betterNodeFinder->find($nodesToSearch, function (\PhpParser\Node $node) use($singleProperty, $nodesToSearch) : bool {
            // property + static fetch
            if (!$node instanceof \PhpParser\Node\Expr\PropertyFetch && !$node instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
                return \false;
            }
            // itself
            if ($this->betterStandardPrinter->areNodesEqual($node, $singleProperty)) {
                return \false;
            }
            // is it the name match?
            if (!$this->nodeNameResolver->areNamesEqual($node, $singleProperty)) {
                return \false;
            }
            return \in_array($node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE), $nodesToSearch, \true);
        });
        return $propertyFetches;
    }
    public function isPropertyUsedInReadContext(\PhpParser\Node\Stmt\Property $property) : bool
    {
        if ($this->isDoctrineProperty($property)) {
            return \true;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo !== null && $phpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode::class)) {
            return \true;
        }
        $privatePropertyFetches = $this->getPrivatePropertyFetches($property);
        foreach ($privatePropertyFetches as $propertyFetch) {
            if ($this->readWritePropertyAnalyzer->isRead($propertyFetch)) {
                return \true;
            }
        }
        // has classLike $this->$variable call?
        /** @var ClassLike $classLike */
        $classLike = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        return (bool) $this->betterNodeFinder->findFirst($classLike->stmts, function (\PhpParser\Node $node) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\PropertyFetch) {
                return \false;
            }
            if (!$this->readWritePropertyAnalyzer->isRead($node)) {
                return \false;
            }
            return $node->name instanceof \PhpParser\Node\Expr;
        });
    }
    public function isPropertyChangeable(\PhpParser\Node\Stmt\Property $property) : bool
    {
        $propertyFetches = $this->getPrivatePropertyFetches($property);
        foreach ($propertyFetches as $propertyFetch) {
            if ($this->isChangeableContext($propertyFetch)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $node
     */
    private function isChangeableContext(\PhpParser\Node $node) : bool
    {
        $parent = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \PhpParser\Node\Expr\PreInc || $parent instanceof \PhpParser\Node\Expr\PreDec || $parent instanceof \PhpParser\Node\Expr\PostInc || $parent instanceof \PhpParser\Node\Expr\PostDec) {
            $parent = $parent->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        if ($parent instanceof \PhpParser\Node\Arg) {
            $readArg = $this->variableToConstantGuard->isReadArg($parent);
            if (!$readArg) {
                return \true;
            }
        }
        return $this->assignManipulator->isLeftPartOfAssign($node);
    }
}
