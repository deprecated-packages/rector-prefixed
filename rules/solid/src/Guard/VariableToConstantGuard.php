<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\SOLID\Guard;

use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionFunction;
final class VariableToConstantGuard
{
    /**
     * @var array<string, array<int>>
     */
    private $referencePositionsByFunctionName = [];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isReadArg(\_PhpScoper0a6b37af0871\PhpParser\Node\Arg $arg) : bool
    {
        $parentParent = $arg->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentParent instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            return \true;
        }
        $functionName = $this->nodeNameResolver->getName($parentParent);
        if ($functionName === null) {
            return \true;
        }
        if (!\function_exists($functionName)) {
            // we don't know
            return \true;
        }
        $referenceParametersPositions = $this->resolveFunctionReferencePositions($functionName);
        if ($referenceParametersPositions === []) {
            // no reference always only write
            return \true;
        }
        $argumentPosition = $this->getArgumentPosition($parentParent, $arg);
        return !\in_array($argumentPosition, $referenceParametersPositions, \true);
    }
    /**
     * @return int[]
     */
    private function resolveFunctionReferencePositions(string $functionName) : array
    {
        if (isset($this->referencePositionsByFunctionName[$functionName])) {
            return $this->referencePositionsByFunctionName[$functionName];
        }
        $referencePositions = [];
        $reflectionFunction = new \ReflectionFunction($functionName);
        foreach ($reflectionFunction->getParameters() as $position => $reflectionParameter) {
            if (!$reflectionParameter->isPassedByReference()) {
                continue;
            }
            $referencePositions[] = $position;
        }
        $this->referencePositionsByFunctionName[$functionName] = $referencePositions;
        return $referencePositions;
    }
    private function getArgumentPosition(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper0a6b37af0871\PhpParser\Node\Arg $desiredArg) : int
    {
        foreach ($funcCall->args as $position => $arg) {
            if ($arg !== $desiredArg) {
                continue;
            }
            return $position;
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
    }
}
