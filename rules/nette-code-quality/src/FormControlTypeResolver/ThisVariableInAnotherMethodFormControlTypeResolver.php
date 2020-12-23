<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
final class ThisVariableInAnotherMethodFormControlTypeResolver implements \_PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \_PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            return [];
        }
        $methodName = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        // handled elsewhere
        if ($methodName === \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::CONSTRUCT) {
            return [];
        }
        $classLike = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
            return [];
        }
        $constructClassMethod = $classLike->getMethod(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructClassMethod === null) {
            return [];
        }
        return $this->methodNamesByInputNamesResolver->resolveExpr($constructClassMethod);
    }
    public function setResolver(\_PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
