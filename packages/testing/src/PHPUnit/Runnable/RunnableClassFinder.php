<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\Runnable;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\NodeFinder;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitor\NameResolver;
use _PhpScoperb75b35f52b74\PhpParser\Parser;
use _PhpScoperb75b35f52b74\PhpParser\ParserFactory;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Testing\Contract\RunnableInterface;
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
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\NodeFinder $nodeFinder)
    {
        $this->parser = (new \_PhpScoperb75b35f52b74\PhpParser\ParserFactory())->create(\_PhpScoperb75b35f52b74\PhpParser\ParserFactory::PREFER_PHP7);
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
        $nodeTraverser = new \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor(new \_PhpScoperb75b35f52b74\PhpParser\NodeVisitor\NameResolver(null, ['preserveOriginalNames' => \true]));
        $nodeTraverser->traverse($nodes);
    }
    /**
     * @param Node[] $nodes
     */
    private function findClassThatImplementsRunnableInterface(array $nodes) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_
    {
        $class = $this->nodeFinder->findFirst($nodes, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
                return \false;
            }
            foreach ((array) $node->implements as $implement) {
                if ((string) $implement !== \_PhpScoperb75b35f52b74\Rector\Testing\Contract\RunnableInterface::class) {
                    continue;
                }
                return \true;
            }
            return \false;
        });
        if (!$class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $class;
    }
}
