<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Naming\NetteControlNaming;
use _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\NodeAnalyzer\ControlDimFetchAnalyzer;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
final class ArrayDimFetchControlTypeResolver implements \_PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NetteCodeQuality\NodeAnalyzer\ControlDimFetchAnalyzer $controlDimFetchAnalyzer, \_PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Naming\NetteControlNaming $netteControlNaming, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer, \_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
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
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch) {
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
        if (!$createComponentClassMethodReturnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return [];
        }
        return [$controlShortName => $createComponentClassMethodReturnType->getClassName()];
    }
    private function matchCreateComponentClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, string $controlShortName) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $callerType = $this->nodeTypeResolver->getStaticType($arrayDimFetch->var);
        if (!$callerType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return null;
        }
        $createComponentClassMethodName = $this->netteControlNaming->createCreateComponentClassMethodName($controlShortName);
        return $this->nodeRepository->findClassMethod($callerType->getClassName(), $createComponentClassMethodName);
    }
}
