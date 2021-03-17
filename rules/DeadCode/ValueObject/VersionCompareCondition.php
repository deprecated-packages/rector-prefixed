<?php

declare (strict_types=1);
namespace Rector\DeadCode\ValueObject;

use Rector\DeadCode\Contract\ConditionInterface;
final class VersionCompareCondition implements \Rector\DeadCode\Contract\ConditionInterface
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
    /**
     * @param int $firstVersion
     * @param int $secondVersion
     * @param string|null $compareSign
     */
    public function __construct($firstVersion, $secondVersion, $compareSign)
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
