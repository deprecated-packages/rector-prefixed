<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\Runnable;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\NodeFinder;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\PhpParser\NodeVisitor\NameResolver;
use _PhpScoper0a6b37af0871\PhpParser\Parser;
use _PhpScoper0a6b37af0871\PhpParser\ParserFactory;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Testing\Contract\RunnableInterface;
final class RunnableClassFinder
{
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var NodeFinder
     */
    private $nodeFinder;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\NodeFinder $nodeFinder)
    {
        $this->parser = (new \_PhpScoper0a6b37af0871\PhpParser\ParserFactory())->create(\_PhpScoper0a6b37af0871\PhpParser\ParserFactory::PREFER_PHP7);
        $this->nodeFinder = $nodeFinder;
    }
    public function find(string $content) : string
    {
        /** @var Node[] $nodes */
        $nodes = $this->parser->parse($content);
        $this->decorateNodesWithNames($nodes);
        $class = $this->findClassThatImplementsRunnableInterface($nodes);
        return (string) $class->namespacedName;
    }
    /**
     * @param Node[] $nodes
     */
    private function decorateNodesWithNames(array $nodes) : void
    {
        $nodeTraverser = new \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor(new \_PhpScoper0a6b37af0871\PhpParser\NodeVisitor\NameResolver(null, ['preserveOriginalNames' => \true]));
        $nodeTraverser->traverse($nodes);
    }
    /**
     * @param Node[] $nodes
     */
    private function findClassThatImplementsRunnableInterface(array $nodes) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_
    {
        $class = $this->nodeFinder->findFirst($nodes, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
                return \false;
            }
            foreach ((array) $node->implements as $implement) {
                if ((string) $implement !== \_PhpScoper0a6b37af0871\Rector\Testing\Contract\RunnableInterface::class) {
                    continue;
                }
                return \true;
            }
            return \false;
        });
        if (!$class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $class;
    }
}
