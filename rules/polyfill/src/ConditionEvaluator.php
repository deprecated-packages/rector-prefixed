<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Polyfill;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Equal;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotEqual;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Polyfill\Contract\ConditionInterface;
use _PhpScoper0a2ac50786fa\Rector\Polyfill\ValueObject\BinaryToVersionCompareCondition;
use _PhpScoper0a2ac50786fa\Rector\Polyfill\ValueObject\VersionCompareCondition;
final class ConditionEvaluator
{
    /**
     * @return bool|int|null
     */
    public function evaluate(\_PhpScoper0a2ac50786fa\Rector\Polyfill\Contract\ConditionInterface $condition)
    {
        if ($condition instanceof \_PhpScoper0a2ac50786fa\Rector\Polyfill\ValueObject\VersionCompareCondition) {
            return $this->evaluateVersionCompareCondition($condition);
        }
        if ($condition instanceof \_PhpScoper0a2ac50786fa\Rector\Polyfill\ValueObject\BinaryToVersionCompareCondition) {
            return $this->evaluateBinaryToVersionCompareCondition($condition);
        }
        return null;
    }
    /**
     * @return bool|int
     */
    private function evaluateVersionCompareCondition(\_PhpScoper0a2ac50786fa\Rector\Polyfill\ValueObject\VersionCompareCondition $versionCompareCondition)
    {
        $compareSign = $versionCompareCondition->getCompareSign();
        if ($compareSign !== null) {
            return \version_compare((string) $versionCompareCondition->getFirstVersion(), (string) $versionCompareCondition->getSecondVersion(), $compareSign);
        }
        return \version_compare((string) $versionCompareCondition->getFirstVersion(), (string) $versionCompareCondition->getSecondVersion());
    }
    private function evaluateBinaryToVersionCompareCondition(\_PhpScoper0a2ac50786fa\Rector\Polyfill\ValueObject\BinaryToVersionCompareCondition $binaryToVersionCompareCondition) : bool
    {
        $versionCompareResult = $this->evaluateVersionCompareCondition($binaryToVersionCompareCondition->getVersionCompareCondition());
        if ($binaryToVersionCompareCondition->getBinaryClass() === \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical::class) {
            return $binaryToVersionCompareCondition->getExpectedValue() === $versionCompareResult;
        }
        if ($binaryToVersionCompareCondition->getBinaryClass() === \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical::class) {
            return $binaryToVersionCompareCondition->getExpectedValue() !== $versionCompareResult;
        }
        if ($binaryToVersionCompareCondition->getBinaryClass() === \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Equal::class) {
            // weak comparison on purpose
            return $binaryToVersionCompareCondition->getExpectedValue() == $versionCompareResult;
        }
        if ($binaryToVersionCompareCondition->getBinaryClass() === \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotEqual::class) {
            // weak comparison on purpose
            return $binaryToVersionCompareCondition->getExpectedValue() != $versionCompareResult;
        }
        throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
    }
}
