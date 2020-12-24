<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class ThisVariableInAnotherMethodFormControlTypeResolver implements \_PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \_PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return [];
        }
        $methodName = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        // handled elsewhere
        if ($methodName === \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT) {
            return [];
        }
        $classLike = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return [];
        }
        $constructClassMethod = $classLike->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructClassMethod === null) {
            return [];
        }
        return $this->methodNamesByInputNamesResolver->resolveExpr($constructClassMethod);
    }
    public function setResolver(\_PhpScoperb75b35f52b74\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
