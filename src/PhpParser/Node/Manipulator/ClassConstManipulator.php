<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class ClassConstManipulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var ParsedNodeCollector
     */
    private $parsedNodeCollector;
    /**
     * @var ClassManipulator
     */
    private $classManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->classManipulator = $classManipulator;
    }
    /**
     * @return ClassConstFetch[]
     */
    public function getAllClassConstFetch(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst $classConst) : array
    {
        /** @var Class_|null $classLike */
        $classLike = $classConst->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return [];
        }
        $searchInNodes = [$classLike];
        $usedTraitNames = $this->classManipulator->getUsedTraits($classLike);
        foreach ($usedTraitNames as $name) {
            $name = $this->parsedNodeCollector->findTrait((string) $name);
            if ($name === null) {
                continue;
            }
            $searchInNodes[] = $name;
        }
        return $this->betterNodeFinder->find($searchInNodes, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($classConst) : bool {
            // itself
            if ($this->betterStandardPrinter->areNodesEqual($node, $classConst)) {
                return \false;
            }
            // property + static fetch
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch) {
                return \false;
            }
            return $this->isNameMatch($node, $classConst);
        });
    }
    /**
     * @see https://github.com/myclabs/php-enum#declaration
     */
    public function isEnum(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst $classConst) : bool
    {
        $classLike = $classConst->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        if ($classLike->extends === null) {
            return \false;
        }
        return $this->nodeNameResolver->isName($classLike->extends, '*Enum');
    }
    private function isNameMatch(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch $classConstFetch, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst $classConst) : bool
    {
        $selfConstantName = 'self::' . $this->nodeNameResolver->getName($classConst);
        $staticConstantName = 'static::' . $this->nodeNameResolver->getName($classConst);
        return $this->nodeNameResolver->isNames($classConstFetch, [$selfConstantName, $staticConstantName]);
    }
}
