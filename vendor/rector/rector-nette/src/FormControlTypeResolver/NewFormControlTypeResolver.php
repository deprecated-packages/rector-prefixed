<?php

declare(strict_types=1);

namespace Rector\Nette\FormControlTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\ValueObject\MethodName;
use Rector\Nette\Contract\FormControlTypeResolverInterface;
use Rector\Nette\Contract\MethodNamesByInputNamesResolverAwareInterface;
use Rector\Nette\NodeResolver\MethodNamesByInputNamesResolver;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeNameResolver\NodeNameResolver;

final class NewFormControlTypeResolver implements FormControlTypeResolverInterface, MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;

    /**
     * @var NodeRepository
     */
    private $nodeRepository;

    public function __construct(NodeNameResolver $nodeNameResolver, NodeRepository $nodeRepository)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeRepository = $nodeRepository;
    }

    /**
     * @return array<string, string>
     */
    public function resolve(Node $node): array
    {
        if (! $node instanceof New_) {
            return [];
        }

        $className = $this->nodeNameResolver->getName($node->class);
        if ($className === null) {
            return [];
        }

        $constructorClassMethod = $this->nodeRepository->findClassMethod($className, MethodName::CONSTRUCT);
        if (! $constructorClassMethod instanceof ClassMethod) {
            return [];
        }

        return $this->methodNamesByInputNamesResolver->resolveExpr($constructorClassMethod);
    }

    /**
     * @return void
     */
    public function setResolver(MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver)
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
