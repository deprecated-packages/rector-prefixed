<?php

declare (strict_types=1);
namespace Rector\DeadCode;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\Equal;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotEqual;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\FuncCall;
use Rector\Core\Php\PhpVersionProvider;
use Rector\Core\PhpParser\Node\Value\ValueResolver;
use Rector\Core\Util\PhpVersionFactory;
use Rector\DeadCode\Contract\ConditionInterface;
use Rector\DeadCode\ValueObject\BinaryToVersionCompareCondition;
use Rector\DeadCode\ValueObject\VersionCompareCondition;
use Rector\NodeNameResolver\NodeNameResolver;
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
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \Rector\Core\Util\PhpVersionFactory $phpVersionFactory)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->valueResolver = $valueResolver;
        $this->phpVersionProvider = $phpVersionProvider;
        $this->phpVersionFactory = $phpVersionFactory;
    }
    /**
     * @return \Rector\DeadCode\Contract\ConditionInterface|null
     */
    public function resolveFromExpr(\PhpParser\Node\Expr $expr)
    {
        if ($this->isVersionCompareFuncCall($expr)) {
            /** @var FuncCall $expr */
            return $this->resolveVersionCompareConditionForFuncCall($expr);
        }
        if (!$expr instanceof \PhpParser\Node\Expr\BinaryOp\Identical && !$expr instanceof \PhpParser\Node\Expr\BinaryOp\Equal && !$expr instanceof \PhpParser\Node\Expr\BinaryOp\NotIdentical && !$expr instanceof \PhpParser\Node\Expr\BinaryOp\NotEqual) {
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
            if (!$versionCompareCondition instanceof \Rector\DeadCode\ValueObject\VersionCompareCondition) {
                return null;
            }
            $expectedValue = $this->valueResolver->getValue($expr->left);
            return new \Rector\DeadCode\ValueObject\BinaryToVersionCompareCondition($versionCompareCondition, $binaryClass, $expectedValue);
        }
        return null;
    }
    private function isVersionCompareFuncCall(\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node, 'version_compare');
    }
    /**
     * @return \Rector\DeadCode\ValueObject\VersionCompareCondition|null
     */
    private function resolveVersionCompareConditionForFuncCall(\PhpParser\Node\Expr\FuncCall $funcCall)
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
        return new \Rector\DeadCode\ValueObject\VersionCompareCondition($firstVersion, $secondVersion, $versionCompareSign);
    }
    /**
     * @return \Rector\DeadCode\ValueObject\BinaryToVersionCompareCondition|null
     */
    private function resolveFuncCall(\PhpParser\Node\Expr\FuncCall $funcCall, \PhpParser\Node\Expr $expr, string $binaryClass)
    {
        $versionCompareCondition = $this->resolveVersionCompareConditionForFuncCall($funcCall);
        if (!$versionCompareCondition instanceof \Rector\DeadCode\ValueObject\VersionCompareCondition) {
            return null;
        }
        $expectedValue = $this->valueResolver->getValue($expr);
        return new \Rector\DeadCode\ValueObject\BinaryToVersionCompareCondition($versionCompareCondition, $binaryClass, $expectedValue);
    }
    /**
     * @return int|null
     */
    private function resolveArgumentValue(\PhpParser\Node\Expr\FuncCall $funcCall, int $argumentPosition)
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
