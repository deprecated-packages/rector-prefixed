<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostDec;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostInc;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreDec;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreInc;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a2ac50786fa\Rector\Doctrine\AbstractRector\DoctrineTrait;
use _PhpScoper0a2ac50786fa\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\ReadWrite\NodeAnalyzer\ReadWritePropertyAnalyzer;
use _PhpScoper0a2ac50786fa\Rector\SOLID\Guard\VariableToConstantGuard;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator $assignManipulator, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Rector\SOLID\Guard\VariableToConstantGuard $variableToConstantGuard, \_PhpScoper0a2ac50786fa\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \_PhpScoper0a2ac50786fa\Rector\ReadWrite\NodeAnalyzer\ReadWritePropertyAnalyzer $readWritePropertyAnalyzer)
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
    public function getPrivatePropertyFetches(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property) : array
    {
        /** @var Class_|null $classLike */
        $classLike = $property->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return [];
        }
        $nodesToSearch = $this->nodeRepository->findUsedTraitsInClass($classLike);
        $nodesToSearch[] = $classLike;
        $singleProperty = $property->props[0];
        /** @var PropertyFetch[]|StaticPropertyFetch[] $propertyFetches */
        $propertyFetches = $this->betterNodeFinder->find($nodesToSearch, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($singleProperty, $nodesToSearch) : bool {
            // property + static fetch
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch) {
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
            return \in_array($node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE), $nodesToSearch, \true);
        });
        return $propertyFetches;
    }
    public function isPropertyUsedInReadContext(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property) : bool
    {
        if ($this->isDoctrineProperty($property)) {
            return \true;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo !== null && $phpDocInfo->hasByType(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode::class)) {
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
        $classLike = $property->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        return (bool) $this->betterNodeFinder->findFirst($classLike->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch) {
                return \false;
            }
            if (!$this->readWritePropertyAnalyzer->isRead($node)) {
                return \false;
            }
            return $node->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
        });
    }
    public function isPropertyChangeable(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property) : bool
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
    private function isChangeableContext(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        $parent = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreInc || $parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreDec || $parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostInc || $parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostDec) {
            $parent = $parent->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        if ($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg) {
            $readArg = $this->variableToConstantGuard->isReadArg($parent);
            if (!$readArg) {
                return \true;
            }
        }
        return $this->assignManipulator->isLeftPartOfAssign($node);
    }
}
