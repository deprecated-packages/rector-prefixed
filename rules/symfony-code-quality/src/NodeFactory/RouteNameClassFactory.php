<?php

declare (strict_types=1);
namespace Rector\SymfonyCodeQuality\NodeFactory;

use PhpParser\Node\Stmt\Namespace_;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\SymfonyCodeQuality\ValueObject\ClassName;
use RectorPrefix20210111\Symplify\Astral\ValueObject\NodeBuilder\ClassBuilder;
use RectorPrefix20210111\Symplify\Astral\ValueObject\NodeBuilder\NamespaceBuilder;
final class RouteNameClassFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
    }
    /**
     * @param array<string, string> $constantNamesToValues
     */
    public function create(array $constantNamesToValues) : \PhpParser\Node\Stmt\Namespace_
    {
        $classBuilder = new \RectorPrefix20210111\Symplify\Astral\ValueObject\NodeBuilder\ClassBuilder(\Rector\SymfonyCodeQuality\ValueObject\ClassName::ROUTE_CLASS_SHORT_NAME);
        $classBuilder->makeFinal();
        foreach ($constantNamesToValues as $constantName => $constantValue) {
            $classConst = $this->nodeFactory->createPublicClassConst($constantName, $constantValue);
            $classBuilder->addStmt($classConst);
        }
        $namespaceBuilder = new \RectorPrefix20210111\Symplify\Astral\ValueObject\NodeBuilder\NamespaceBuilder(\Rector\SymfonyCodeQuality\ValueObject\ClassName::ROUTE_NAME_NAMESPACE);
        $namespaceBuilder->addStmt($classBuilder->getNode());
        return $namespaceBuilder->getNode();
    }
}
