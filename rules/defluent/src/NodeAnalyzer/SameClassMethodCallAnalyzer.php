<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Defluent\NodeAnalyzer;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
use _PhpScoper0a2ac50786fa\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
final class SameClassMethodCallAnalyzer
{
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * @param MethodCall[] $chainMethodCalls
     */
    public function haveSingleClass(array $chainMethodCalls) : bool
    {
        // are method calls located in the same class?
        $classOfClassMethod = [];
        foreach ($chainMethodCalls as $chainMethodCall) {
            $classMethod = $this->nodeRepository->findClassMethodByMethodCall($chainMethodCall);
            if ($classMethod instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod) {
                $classOfClassMethod[] = $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            } else {
                $classOfClassMethod[] = null;
            }
        }
        $uniqueClasses = \array_unique($classOfClassMethod);
        return \count($uniqueClasses) < 2;
    }
    /**
     * @param string[] $calleeUniqueTypes
     */
    public function isCorrectTypeCount(array $calleeUniqueTypes, \_PhpScoper0a2ac50786fa\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface $firstCallFactoryAware) : bool
    {
        if ($calleeUniqueTypes === []) {
            return \false;
        }
        // in case of factory method, 2 methods are allowed
        if ($firstCallFactoryAware->isFirstCallFactory()) {
            return \count($calleeUniqueTypes) === 2;
        }
        return \count($calleeUniqueTypes) === 1;
    }
}
