<?php

declare (strict_types=1);
namespace Rector\Polyfill;

use PhpParser\Node\Expr\BinaryOp\Equal;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotEqual;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Polyfill\Contract\ConditionInterface;
use Rector\Polyfill\ValueObject\BinaryToVersionCompareCondition;
use Rector\Polyfill\ValueObject\VersionCompareCondition;
final class ConditionEvaluator
{
    /**
     * @return bool|int|null
     */
    public function evaluate(\Rector\Polyfill\Contract\ConditionInterface $condition)
    {
        if ($condition instanceof \Rector\Polyfill\ValueObject\VersionCompareCondition) {
            return $this->evaluateVersionCompareCondition($condition);
        }
        if ($condition instanceof \Rector\Polyfill\ValueObject\BinaryToVersionCompareCondition) {
            return $this->evaluateBinaryToVersionCompareCondition($condition);
        }
        return null;
    }
    /**
     * @return bool|int
     */
    private function evaluateVersionCompareCondition(\Rector\Polyfill\ValueObject\VersionCompareCondition $versionCompareCondition)
    {
        $compareSign = $versionCompareCondition->getCompareSign();
        if ($compareSign !== null) {
            return \version_compare((string) $versionCompareCondition->getFirstVersion(), (string) $versionCompareCondition->getSecondVersion(), $compareSign);
        }
        return \version_compare((string) $versionCompareCondition->getFirstVersion(), (string) $versionCompareCondition->getSecondVersion());
    }
    private function evaluateBinaryToVersionCompareCondition(\Rector\Polyfill\ValueObject\BinaryToVersionCompareCondition $binaryToVersionCompareCondition) : bool
    {
        $versionCompareResult = $this->evaluateVersionCompareCondition($binaryToVersionCompareCondition->getVersionCompareCondition());
        if ($binaryToVersionCompareCondition->getBinaryClass() === \PhpParser\Node\Expr\BinaryOp\Identical::class) {
            return $binaryToVersionCompareCondition->getExpectedValue() === $versionCompareResult;
        }
        if ($binaryToVersionCompareCondition->getBinaryClass() === \PhpParser\Node\Expr\BinaryOp\NotIdentical::class) {
            return $binaryToVersionCompareCondition->getExpectedValue() !== $versionCompareResult;
        }
        if ($binaryToVersionCompareCondition->getBinaryClass() === \PhpParser\Node\Expr\BinaryOp\Equal::class) {
            // weak comparison on purpose
            return $binaryToVersionCompareCondition->getExpectedValue() == $versionCompareResult;
        }
        if ($binaryToVersionCompareCondition->getBinaryClass() === \PhpParser\Node\Expr\BinaryOp\NotEqual::class) {
            // weak comparison on purpose
            return $binaryToVersionCompareCondition->getExpectedValue() != $versionCompareResult;
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException();
    }
}
