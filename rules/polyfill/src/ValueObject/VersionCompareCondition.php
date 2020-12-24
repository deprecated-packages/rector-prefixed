<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Polyfill\ValueObject;

use _PhpScopere8e811afab72\Rector\Polyfill\Contract\ConditionInterface;
final class VersionCompareCondition implements \_PhpScopere8e811afab72\Rector\Polyfill\Contract\ConditionInterface
{
    /**
     * @var int
     */
    private $firstVersion;
    /**
     * @var int
     */
    private $secondVersion;
    /**
     * @var string|null
     */
    private $compareSign;
    public function __construct(int $firstVersion, int $secondVersion, ?string $compareSign)
    {
        $this->firstVersion = $firstVersion;
        $this->secondVersion = $secondVersion;
        $this->compareSign = $compareSign;
    }
    public function getFirstVersion() : int
    {
        return $this->firstVersion;
    }
    public function getSecondVersion() : int
    {
        return $this->secondVersion;
    }
    public function getCompareSign() : ?string
    {
        return $this->compareSign;
    }
}
