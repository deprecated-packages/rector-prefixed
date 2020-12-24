<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
final class GetComponentMethodCallFormControlTypeResolver implements \_PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \_PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \_PhpScoper2a4e7ab1ecbc\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->valueResolver = $valueResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall) {
            return [];
        }
        if (!$this->nodeNameResolver->isName($node->name, 'getComponent')) {
            return [];
        }
        $createComponentClassMethodName = $this->createCreateComponentMethodName($node);
        $staticType = $this->nodeTypeResolver->getStaticType($node);
        if (!$staticType instanceof \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType) {
            return [];
        }
        // combine constructor + method body name
        $constructorClassMethodData = [];
        $constructorClassMethod = $this->nodeRepository->findClassMethod($staticType->getClassName(), \_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructorClassMethod !== null) {
            $constructorClassMethodData = $this->methodNamesByInputNamesResolver->resolveExpr($constructorClassMethod);
        }
        $callerType = $this->nodeTypeResolver->getStaticType($node->var);
        $createComponentClassMethodData = [];
        if ($callerType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName) {
            $createComponentClassMethod = $this->nodeRepository->findClassMethod($callerType->getClassName(), $createComponentClassMethodName);
            if ($createComponentClassMethod !== null) {
                $createComponentClassMethodData = $this->methodNamesByInputNamesResolver->resolveExpr($createComponentClassMethod);
            }
        }
        return \array_merge($constructorClassMethodData, $createComponentClassMethodData);
    }
    public function setResolver(\_PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
    private function createCreateComponentMethodName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $firstArgumentValue = $methodCall->args[0]->value;
        return 'createComponent' . \ucfirst($this->valueResolver->getValue($firstArgumentValue));
    }
}
