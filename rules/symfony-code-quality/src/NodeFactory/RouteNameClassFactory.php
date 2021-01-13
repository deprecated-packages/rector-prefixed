<?php

declare (strict_types=1);
namespace Rector\SymfonyCodeQuality\NodeFactory;

use PhpParser\Node\Stmt\Namespace_;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\SymfonyCodeQuality\ValueObject\ClassName;
use Rector\SymfonyCodeQuality\ValueObject\ConstantNameAndValue;
use RectorPrefix20210113\Symplify\Astral\ValueObject\NodeBuilder\ClassBuilder;
use RectorPrefix20210113\Symplify\Astral\ValueObject\NodeBuilder\NamespaceBuilder;
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
     * @param ConstantNameAndValue[] $constantNamesAndValues
     */
    public function create(array $constantNamesAndValues) : \PhpParser\Node\Stmt\Namespace_
    {
        $classBuilder = new \RectorPrefix20210113\Symplify\Astral\ValueObject\NodeBuilder\ClassBuilder(\Rector\SymfonyCodeQuality\ValueObject\ClassName::ROUTE_CLASS_SHORT_NAME);
        $classBuilder->makeFinal();
        foreach ($constantNamesAndValues as $constantNameAndValue) {
            $classConst = $this->nodeFactory->createPublicClassConst($constantNameAndValue->getName(), $constantNameAndValue->getValue());
            $classBuilder->addStmt($classConst);
        }
        $namespaceBuilder = new \RectorPrefix20210113\Symplify\Astral\ValueObject\NodeBuilder\NamespaceBuilder(\Rector\SymfonyCodeQuality\ValueObject\ClassName::ROUTE_NAME_NAMESPACE);
        $namespaceBuilder->addStmt($classBuilder->getNode());
        return $namespaceBuilder->getNode();
    }
}
