<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostDec;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostInc;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreDec;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreInc;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\Doctrine\AbstractRector\DoctrineTrait;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\ReadWrite\NodeAnalyzer\ReadWritePropertyAnalyzer;
use _PhpScoperb75b35f52b74\Rector\SOLID\Guard\VariableToConstantGuard;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator $assignManipulator, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\SOLID\Guard\VariableToConstantGuard $variableToConstantGuard, \_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \_PhpScoperb75b35f52b74\Rector\ReadWrite\NodeAnalyzer\ReadWritePropertyAnalyzer $readWritePropertyAnalyzer)
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
    public function getPrivatePropertyFetches(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : array
    {
        /** @var Class_|null $classLike */
        $classLike = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return [];
        }
        $nodesToSearch = $this->nodeRepository->findUsedTraitsInClass($classLike);
        $nodesToSearch[] = $classLike;
        $singleProperty = $property->props[0];
        /** @var PropertyFetch[]|StaticPropertyFetch[] $propertyFetches */
        $propertyFetches = $this->betterNodeFinder->find($nodesToSearch, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($singleProperty, $nodesToSearch) : bool {
            // property + static fetch
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch) {
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
            return \in_array($node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE), $nodesToSearch, \true);
        });
        return $propertyFetches;
    }
    public function isPropertyUsedInReadContext(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : bool
    {
        if ($this->isDoctrineProperty($property)) {
            return \true;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo !== null && $phpDocInfo->hasByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode::class)) {
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
        $classLike = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        return (bool) $this->betterNodeFinder->findFirst($classLike->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
                return \false;
            }
            if (!$this->readWritePropertyAnalyzer->isRead($node)) {
                return \false;
            }
            return $node->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr;
        });
    }
    public function isPropertyChangeable(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : bool
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
    private function isChangeableContext(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        $parent = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreInc || $parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreDec || $parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostInc || $parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostDec) {
            $parent = $parent->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Arg) {
            $readArg = $this->variableToConstantGuard->isReadArg($parent);
            if (!$readArg) {
                return \true;
            }
        }
        return $this->assignManipulator->isLeftPartOfAssign($node);
    }
}
