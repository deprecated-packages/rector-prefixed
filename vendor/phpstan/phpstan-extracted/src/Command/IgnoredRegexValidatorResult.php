<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Command;

class IgnoredRegexValidatorResult
{
    /** @var array<string, string> */
    private $ignoredTypes;
    /** @var bool */
    private $anchorsInTheMiddle;
    /** @var bool */
    private $allErrorsIgnored;
    /** @var string|null */
    private $wrongSequence;
    /** @var string|null */
    private $escapedWrongSequence;
    /**
     * @param array<string, string> $ignoredTypes
     * @param bool $anchorsInTheMiddle
     * @param bool $allErrorsIgnored
     */
    public function __construct(array $ignoredTypes, bool $anchorsInTheMiddle, bool $allErrorsIgnored, ?string $wrongSequence = null, ?string $escapedWrongSequence = null)
    {
        $this->ignoredTypes = $ignoredTypes;
        $this->anchorsInTheMiddle = $anchorsInTheMiddle;
        $this->allErrorsIgnored = $allErrorsIgnored;
        $this->wrongSequence = $wrongSequence;
        $this->escapedWrongSequence = $escapedWrongSequence;
    }
    /**
     * @return array<string, string>
     */
    public function getIgnoredTypes() : array
    {
        return $this->ignoredTypes;
    }
    public function hasAnchorsInTheMiddle() : bool
    {
        return $this->anchorsInTheMiddle;
    }
    public function areAllErrorsIgnored() : bool
    {
        return $this->allErrorsIgnored;
    }
    public function getWrongSequence() : ?string
    {
        return $this->wrongSequence;
    }
    public function getEscapedWrongSequence() : ?string
    {
        return $this->escapedWrongSequence;
    }
}
