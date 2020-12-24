<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;
final class VariableConstructorFormControlTypeResolver implements \_PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \_PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
            return [];
        }
        // handled else-where
        if ($this->nodeNameResolver->isName($node, 'this')) {
            return [];
        }
        $formType = $this->nodeTypeResolver->getStaticType($node);
        if (!$formType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName) {
            return [];
        }
        if (!\is_a($formType->getClassName(), '_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\UI\\Form', \true)) {
            return [];
        }
        $constructorClassMethod = $this->nodeRepository->findClassMethod($formType->getClassName(), \_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructorClassMethod === null) {
            return [];
        }
        return $this->methodNamesByInputNamesResolver->resolveExpr($constructorClassMethod);
    }
    public function setResolver(\_PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
