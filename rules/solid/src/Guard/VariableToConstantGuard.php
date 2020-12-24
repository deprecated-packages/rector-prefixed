<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Guard;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isReadArg(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg $arg) : bool
    {
        $parentParent = $arg->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentParent instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall) {
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
    private function getArgumentPosition(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg $desiredArg) : int
    {
        foreach ($funcCall->args as $position => $arg) {
            if ($arg !== $desiredArg) {
                continue;
            }
            return $position;
        }
        throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
    }
}
