<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\NodeResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\ValueObject\NetteFormMethodNameToControlType;
final class FormVariableInputNameTypeResolver
{
    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver)
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
    public function resolveControlTypeByInputName(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $formOrControlExpr, string $inputName) : string
    {
        $methodNamesByInputNames = $this->methodNamesByInputNamesResolver->resolveExpr($formOrControlExpr);
        $formAddMethodName = $methodNamesByInputNames[$inputName] ?? null;
        if ($formAddMethodName === null) {
            $message = \sprintf('Type was not found for "%s" input name', $inputName);
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException($message);
        }
        foreach (\_PhpScoper0a6b37af0871\Rector\NetteCodeQuality\ValueObject\NetteFormMethodNameToControlType::METHOD_NAME_TO_CONTROL_TYPE as $methodName => $controlType) {
            if ($methodName !== $formAddMethodName) {
                continue;
            }
            return $controlType;
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedYetException($formAddMethodName);
    }
}
