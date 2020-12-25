<?php

declare (strict_types=1);
namespace Rector\Testing\PHPUnit\Runnable;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\NodeFinder;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Testing\Contract\RunnableInterface;
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
    public function __construct(\PhpParser\NodeFinder $nodeFinder)
    {
        $this->parser = (new \PhpParser\ParserFactory())->create(\PhpParser\ParserFactory::PREFER_PHP7);
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
        $nodeTraverser = new \PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor(new \PhpParser\NodeVisitor\NameResolver(null, ['preserveOriginalNames' => \true]));
        $nodeTraverser->traverse($nodes);
    }
    /**
     * @param Node[] $nodes
     */
    private function findClassThatImplementsRunnableInterface(array $nodes) : \PhpParser\Node\Stmt\Class_
    {
        $class = $this->nodeFinder->findFirst($nodes, function (\PhpParser\Node $node) : bool {
            if (!$node instanceof \PhpParser\Node\Stmt\Class_) {
                return \false;
            }
            foreach ($node->implements as $implement) {
                if ((string) $implement !== \Rector\Testing\Contract\RunnableInterface::class) {
                    continue;
                }
                return \true;
            }
            return \false;
        });
        if (!$class instanceof \PhpParser\Node\Stmt\Class_) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return $class;
    }
}
