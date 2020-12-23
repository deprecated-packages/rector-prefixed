<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\BetterReflection\SourceLocator;

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
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_ $namespace, string $fileName)
    {
        $this->node = $node;
        $this->namespace = $namespace;
        $this->fileName = $fileName;
    }
    /**
     * @return T
     */
    public function getNode() : \_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        return $this->node;
    }
    public function getNamespace() : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_
    {
        return $this->namespace;
    }
    public function getFileName() : string
    {
        return $this->fileName;
    }
}
