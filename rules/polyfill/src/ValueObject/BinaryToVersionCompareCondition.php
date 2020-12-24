<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Polyfill\ValueObject;

use _PhpScoperb75b35f52b74\Rector\Polyfill\Contract\ConditionInterface;
final class BinaryToVersionCompareCondition implements \_PhpScoperb75b35f52b74\Rector\Polyfill\Contract\ConditionInterface
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Polyfill\ValueObject\VersionCompareCondition $versionCompareCondition, string $binaryClass, $expectedValue)
    {
        $this->versionCompareCondition = $versionCompareCondition;
        $this->binaryClass = $binaryClass;
        $this->expectedValue = $expectedValue;
    }
    public function getVersionCompareCondition() : \_PhpScoperb75b35f52b74\Rector\Polyfill\ValueObject\VersionCompareCondition
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
