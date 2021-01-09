<?php

declare (strict_types=1);
namespace Rector\SymfonyPHPUnit;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\Class_;
use Rector\Core\PhpParser\Node\Value\ValueResolver;
use Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeAnalyzer;
use RectorPrefix20210109\Symfony\Component\HttpFoundation\Session\SessionInterface;
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
    public function __construct(\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeAnalyzer $kernelTestCaseNodeAnalyzer, \Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->kernelTestCaseNodeAnalyzer = $kernelTestCaseNodeAnalyzer;
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->valueResolver = $valueResolver;
    }
    /**
     * @return string[]
     */
    public function collectContainerGetServiceTypes(\PhpParser\Node\Stmt\Class_ $class, bool $skipSetUpMethod = \true) : array
    {
        $serviceTypes = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($class->stmts, function (\PhpParser\Node $node) use(&$serviceTypes, $skipSetUpMethod) : ?Node {
            if (!$node instanceof \PhpParser\Node\Expr\MethodCall) {
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
            if ($serviceType === null) {
                return null;
            }
            if (!\is_string($serviceType)) {
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
        return $serviceType === \RectorPrefix20210109\Symfony\Component\HttpFoundation\Session\SessionInterface::class;
    }
}
