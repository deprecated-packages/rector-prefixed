<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Polyfill;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Equal;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotEqual;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\Rector\Core\Php\PhpVersionProvider;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoper0a6b37af0871\Rector\Core\Util\PhpVersionFactory;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\Polyfill\Contract\ConditionInterface;
use _PhpScoper0a6b37af0871\Rector\Polyfill\ValueObject\BinaryToVersionCompareCondition;
use _PhpScoper0a6b37af0871\Rector\Polyfill\ValueObject\VersionCompareCondition;
final class ConditionResolver
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    /**
     * @var PhpVersionFactory
     */
    private $phpVersionFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \_PhpScoper0a6b37af0871\Rector\Core\Util\PhpVersionFactory $phpVersionFactory)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->valueResolver = $valueResolver;
        $this->phpVersionProvider = $phpVersionProvider;
        $this->phpVersionFactory = $phpVersionFactory;
    }
    public function resolveFromExpr(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : ?\_PhpScoper0a6b37af0871\Rector\Polyfill\Contract\ConditionInterface
    {
        if ($this->isVersionCompareFuncCall($expr)) {
            /** @var FuncCall $expr */
            return $this->resolveVersionCompareConditionForFuncCall($expr);
        }
        if (!$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical && !$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Equal && !$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical && !$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotEqual) {
            return null;
        }
        $binaryClass = \get_class($expr);
        if ($this->isVersionCompareFuncCall($expr->left)) {
            /** @var FuncCall $funcCall */
            $funcCall = $expr->left;
            return $this->resolveFuncCall($funcCall, $expr->right, $binaryClass);
        }
        if ($this->isVersionCompareFuncCall($expr->right)) {
            /** @var FuncCall $funcCall */
            $funcCall = $expr->right;
            $versionCompareCondition = $this->resolveVersionCompareConditionForFuncCall($funcCall);
            if ($versionCompareCondition === null) {
                return null;
            }
            $expectedValue = $this->valueResolver->getValue($expr->left);
            return new \_PhpScoper0a6b37af0871\Rector\Polyfill\ValueObject\BinaryToVersionCompareCondition($versionCompareCondition, $binaryClass, $expectedValue);
        }
        return null;
    }
    private function isVersionCompareFuncCall(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node, 'version_compare');
    }
    private function resolveVersionCompareConditionForFuncCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall) : ?\_PhpScoper0a6b37af0871\Rector\Polyfill\ValueObject\VersionCompareCondition
    {
        $firstVersion = $this->resolveArgumentValue($funcCall, 0);
        if ($firstVersion === null) {
            return null;
        }
        $secondVersion = $this->resolveArgumentValue($funcCall, 1);
        if ($secondVersion === null) {
            return null;
        }
        // includes compare sign as 3rd argument
        $versionCompareSign = null;
        if (isset($funcCall->args[2])) {
            $versionCompareSign = $this->valueResolver->getValue($funcCall->args[2]->value);
        }
        return new \_PhpScoper0a6b37af0871\Rector\Polyfill\ValueObject\VersionCompareCondition($firstVersion, $secondVersion, $versionCompareSign);
    }
    private function resolveFuncCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr, string $binaryClass) : ?\_PhpScoper0a6b37af0871\Rector\Polyfill\ValueObject\BinaryToVersionCompareCondition
    {
        $versionCompareCondition = $this->resolveVersionCompareConditionForFuncCall($funcCall);
        if ($versionCompareCondition === null) {
            return null;
        }
        $expectedValue = $this->valueResolver->getValue($expr);
        return new \_PhpScoper0a6b37af0871\Rector\Polyfill\ValueObject\BinaryToVersionCompareCondition($versionCompareCondition, $binaryClass, $expectedValue);
    }
    private function resolveArgumentValue(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall, int $argumentPosition) : ?int
    {
        $firstArgValue = $funcCall->args[$argumentPosition]->value;
        /** @var mixed|null $version */
        $version = $this->valueResolver->getValue($firstArgValue);
        if (\in_array($version, ['PHP_VERSION', 'PHP_VERSION_ID'], \true)) {
            return $this->phpVersionProvider->provide();
        }
        if (\is_string($version)) {
            return $this->phpVersionFactory->createIntVersion($version);
        }
        return $version;
    }
}
