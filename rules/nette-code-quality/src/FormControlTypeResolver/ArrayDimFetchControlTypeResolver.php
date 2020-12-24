<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Naming\NetteControlNaming;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeAnalyzer\ControlDimFetchAnalyzer;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
final class ArrayDimFetchControlTypeResolver implements \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface
{
    /**
     * @var ControlDimFetchAnalyzer
     */
    private $controlDimFetchAnalyzer;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NetteControlNaming
     */
    private $netteControlNaming;
    /**
     * @var ReturnTypeInferer
     */
    private $returnTypeInferer;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeAnalyzer\ControlDimFetchAnalyzer $controlDimFetchAnalyzer, \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Naming\NetteControlNaming $netteControlNaming, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer, \_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->controlDimFetchAnalyzer = $controlDimFetchAnalyzer;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->netteControlNaming = $netteControlNaming;
        $this->returnTypeInferer = $returnTypeInferer;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            return [];
        }
        $controlShortName = $this->controlDimFetchAnalyzer->matchName($node);
        if ($controlShortName === null) {
            return [];
        }
        $createComponentClassMethod = $this->matchCreateComponentClassMethod($node, $controlShortName);
        if ($createComponentClassMethod === null) {
            return [];
        }
        $createComponentClassMethodReturnType = $this->returnTypeInferer->inferFunctionLike($createComponentClassMethod);
        if (!$createComponentClassMethodReturnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return [];
        }
        return [$controlShortName => $createComponentClassMethodReturnType->getClassName()];
    }
    private function matchCreateComponentClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, string $controlShortName) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $callerType = $this->nodeTypeResolver->getStaticType($arrayDimFetch->var);
        if (!$callerType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return null;
        }
        $createComponentClassMethodName = $this->netteControlNaming->createCreateComponentClassMethodName($controlShortName);
        return $this->nodeRepository->findClassMethod($callerType->getClassName(), $createComponentClassMethodName);
    }
}
