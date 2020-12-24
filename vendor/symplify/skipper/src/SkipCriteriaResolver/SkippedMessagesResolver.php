<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\Skipper\SkipCriteriaResolver;

use _PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScopere8e811afab72\Symplify\Skipper\ValueObject\Option;
final class SkippedMessagesResolver
{
    /**
     * @var array<string, string[]|null>
     */
    private $skippedMessages = [];
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->parameterProvider = $parameterProvider;
    }
    /**
     * @return array<string, string[]|null>
     */
    public function resolve() : array
    {
        if ($this->skippedMessages !== []) {
            return $this->skippedMessages;
        }
        $skip = $this->parameterProvider->provideArrayParameter(\_PhpScopere8e811afab72\Symplify\Skipper\ValueObject\Option::SKIP);
        foreach ($skip as $key => $value) {
            // e.g. [SomeClass::class] → shift values to [SomeClass::class => null]
            if (\is_int($key)) {
                $key = $value;
                $value = null;
            }
            if (!\is_string($key)) {
                continue;
            }
            if (\substr_count($key, ' ') === 0) {
                continue;
            }
            $this->skippedMessages[$key] = $value;
        }
        return $this->skippedMessages;
    }
}
