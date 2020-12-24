<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\SOLID\NodeFinder;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class ParentClassConstantNodeFinder
{
    /**
     * @var ParsedNodeCollector
     */
    private $parsedNodeCollector;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector)
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
    }
    public function find(string $class, string $constant) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst
    {
        $classNode = $this->parsedNodeCollector->findClass($class);
        if ($classNode === null) {
            return null;
        }
        /** @var string|null $parentClassName */
        $parentClassName = $classNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName === null) {
            return null;
        }
        return $this->parsedNodeCollector->findClassConstant($parentClassName, $constant);
    }
}
