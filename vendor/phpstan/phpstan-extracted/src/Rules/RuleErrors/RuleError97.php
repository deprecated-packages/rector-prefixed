<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError97 implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleError, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\MetadataRuleError, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\NonIgnorableRuleError
{
    /** @var string */
    public $message;
    /** @var mixed[] */
    public $metadata;
    public function getMessage() : string
    {
        return $this->message;
    }
    /**
     * @return mixed[]
     */
    public function getMetadata() : array
    {
        return $this->metadata;
    }
}
