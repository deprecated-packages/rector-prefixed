<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Naming\NetteControlNaming;
use _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\NodeAnalyzer\ControlDimFetchAnalyzer;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
final class ArrayDimFetchControlTypeResolver implements \_PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NetteCodeQuality\NodeAnalyzer\ControlDimFetchAnalyzer $controlDimFetchAnalyzer, \_PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Naming\NetteControlNaming $netteControlNaming, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer, \_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
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
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch) {
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
        if (!$createComponentClassMethodReturnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
            return [];
        }
        return [$controlShortName => $createComponentClassMethodReturnType->getClassName()];
    }
    private function matchCreateComponentClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, string $controlShortName) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        $callerType = $this->nodeTypeResolver->getStaticType($arrayDimFetch->var);
        if (!$callerType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
            return null;
        }
        $createComponentClassMethodName = $this->netteControlNaming->createCreateComponentClassMethodName($controlShortName);
        return $this->nodeRepository->findClassMethod($callerType->getClassName(), $createComponentClassMethodName);
    }
}
