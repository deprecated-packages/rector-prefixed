<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Testing\PHPUnit\Runnable;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\NodeFinder;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PhpParser\NodeVisitor\NameResolver;
use _PhpScopere8e811afab72\PhpParser\Parser;
use _PhpScopere8e811afab72\PhpParser\ParserFactory;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Testing\Contract\RunnableInterface;
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
    public function __construct(\_PhpScopere8e811afab72\PhpParser\NodeFinder $nodeFinder)
    {
        $this->parser = (new \_PhpScopere8e811afab72\PhpParser\ParserFactory())->create(\_PhpScopere8e811afab72\PhpParser\ParserFactory::PREFER_PHP7);
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
        $nodeTraverser = new \_PhpScopere8e811afab72\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor(new \_PhpScopere8e811afab72\PhpParser\NodeVisitor\NameResolver(null, ['preserveOriginalNames' => \true]));
        $nodeTraverser->traverse($nodes);
    }
    /**
     * @param Node[] $nodes
     */
    private function findClassThatImplementsRunnableInterface(array $nodes) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_
    {
        $class = $this->nodeFinder->findFirst($nodes, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
                return \false;
            }
            foreach ((array) $node->implements as $implement) {
                if ((string) $implement !== \_PhpScopere8e811afab72\Rector\Testing\Contract\RunnableInterface::class) {
                    continue;
                }
                return \true;
            }
            return \false;
        });
        if (!$class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $class;
    }
}
