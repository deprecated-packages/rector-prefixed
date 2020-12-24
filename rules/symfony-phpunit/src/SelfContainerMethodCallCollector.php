<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\SymfonyPHPUnit;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a6b37af0871\Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeAnalyzer;
use _PhpScoper0a6b37af0871\Symfony\Component\HttpFoundation\Session\SessionInterface;
final class SelfContainerMethodCallCollector
{
    /**
     * @var KernelTestCaseNodeAnalyzer
     */
    private $kernelTestCaseNodeAnalyzer;
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper0a6b37af0871\Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeAnalyzer $kernelTestCaseNodeAnalyzer, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->kernelTestCaseNodeAnalyzer = $kernelTestCaseNodeAnalyzer;
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->valueResolver = $valueResolver;
    }
    /**
     * @return string[]
     */
    public function collectContainerGetServiceTypes(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, bool $skipSetUpMethod = \true) : array
    {
        $serviceTypes = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($class->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$serviceTypes, $skipSetUpMethod) : ?Node {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
                return null;
            }
            if (!$this->kernelTestCaseNodeAnalyzer->isOnContainerGetMethodCall($node)) {
                return null;
            }
            if ($skipSetUpMethod && $this->kernelTestCaseNodeAnalyzer->isSetUpOrEmptyMethod($node)) {
                return null;
            }
            /** @var MethodCall $node */
            $serviceType = $this->valueResolver->getValue($node->args[0]->value);
            if ($serviceType === null || !\is_string($serviceType)) {
                return null;
            }
            if ($this->shouldSkipServiceType($serviceType)) {
                return null;
            }
            $serviceTypes[] = $serviceType;
            return null;
        });
        return \array_unique($serviceTypes);
    }
    private function shouldSkipServiceType(string $serviceType) : bool
    {
        return $serviceType === \_PhpScoper0a6b37af0871\Symfony\Component\HttpFoundation\Session\SessionInterface::class;
    }
}
