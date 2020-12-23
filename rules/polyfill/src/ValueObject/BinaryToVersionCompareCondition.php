<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Polyfill\ValueObject;

use _PhpScoper0a2ac50786fa\Rector\Polyfill\Contract\ConditionInterface;
final class BinaryToVersionCompareCondition implements \_PhpScoper0a2ac50786fa\Rector\Polyfill\Contract\ConditionInterface
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Polyfill\ValueObject\VersionCompareCondition $versionCompareCondition, string $binaryClass, $expectedValue)
    {
        $this->versionCompareCondition = $versionCompareCondition;
        $this->binaryClass = $binaryClass;
        $this->expectedValue = $expectedValue;
    }
    public function getVersionCompareCondition() : \_PhpScoper0a2ac50786fa\Rector\Polyfill\ValueObject\VersionCompareCondition
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
