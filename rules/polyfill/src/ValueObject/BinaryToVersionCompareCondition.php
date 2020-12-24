<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Polyfill\ValueObject;

use _PhpScopere8e811afab72\Rector\Polyfill\Contract\ConditionInterface;
final class BinaryToVersionCompareCondition implements \_PhpScopere8e811afab72\Rector\Polyfill\Contract\ConditionInterface
{
    /**
     * @var string
     */
    private $binaryClass;
    /**
     * @var VersionCompareCondition
     */
    private $versionCompareCondition;
    /**
     * @var mixed
     */
    private $expectedValue;
    /**
     * @param mixed $expectedValue
     */
    public function __construct(\_PhpScopere8e811afab72\Rector\Polyfill\ValueObject\VersionCompareCondition $versionCompareCondition, string $binaryClass, $expectedValue)
    {
        $this->versionCompareCondition = $versionCompareCondition;
        $this->binaryClass = $binaryClass;
        $this->expectedValue = $expectedValue;
    }
    public function getVersionCompareCondition() : \_PhpScopere8e811afab72\Rector\Polyfill\ValueObject\VersionCompareCondition
    {
        return $this->versionCompareCondition;
    }
    public function getBinaryClass() : string
    {
        return $this->binaryClass;
    }
    /**
     * @return mixed
     */
    public function getExpectedValue()
    {
        return $this->expectedValue;
    }
}
