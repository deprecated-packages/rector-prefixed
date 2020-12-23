<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\SOLID\NodeFinder;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper0a2ac50786fa\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
final class ParentClassConstantNodeFinder
{
    /**
     * @var ParsedNodeCollector
     */
    private $parsedNodeCollector;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector)
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
    }
    public function find(string $class, string $constant) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassConst
    {
        $classNode = $this->parsedNodeCollector->findClass($class);
        if ($classNode === null) {
            return null;
        }
        /** @var string|null $parentClassName */
        $parentClassName = $classNode->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName === null) {
            return null;
        }
        return $this->parsedNodeCollector->findClassConstant($parentClassName, $constant);
    }
}
