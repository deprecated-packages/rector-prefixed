<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\Runnable;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeFinder;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitor\NameResolver;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Parser;
use _PhpScoper2a4e7ab1ecbc\PhpParser\ParserFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\Contract\RunnableInterface;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\NodeFinder $nodeFinder)
    {
        $this->parser = (new \_PhpScoper2a4e7ab1ecbc\PhpParser\ParserFactory())->create(\_PhpScoper2a4e7ab1ecbc\PhpParser\ParserFactory::PREFER_PHP7);
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
        $nodeTraverser = new \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor(new \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitor\NameResolver(null, ['preserveOriginalNames' => \true]));
        $nodeTraverser->traverse($nodes);
    }
    /**
     * @param Node[] $nodes
     */
    private function findClassThatImplementsRunnableInterface(array $nodes) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_
    {
        $class = $this->nodeFinder->findFirst($nodes, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_) {
                return \false;
            }
            foreach ((array) $node->implements as $implement) {
                if ((string) $implement !== \_PhpScoper2a4e7ab1ecbc\Rector\Testing\Contract\RunnableInterface::class) {
                    continue;
                }
                return \true;
            }
            return \false;
        });
        if (!$class instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $class;
    }
}
