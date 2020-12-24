<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\SourceLocator;

/**
 * @template-covariant T of \PhpParser\Node
 */
class FetchedNode
{
    /** @var T */
    private $node;
    /** @var \PhpParser\Node\Stmt\Namespace_|null */
    private $namespace;
    /** @var string */
    private $fileName;
    /**
     * @param T $node
     * @param \PhpParser\Node\Stmt\Namespace_|null $namespace
     * @param string $fileName
     */
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node $node, ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_ $namespace, string $fileName)
    {
        $this->node = $node;
        $this->namespace = $namespace;
        $this->fileName = $fileName;
    }
    /**
     * @return T
     */
    public function getNode() : \_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->node;
    }
    public function getNamespace() : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_
    {
        return $this->namespace;
    }
    public function getFileName() : string
    {
        return $this->fileName;
    }
}
