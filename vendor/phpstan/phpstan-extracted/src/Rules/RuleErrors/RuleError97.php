<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError97 implements \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleError, \_PhpScoperb75b35f52b74\PHPStan\Rules\MetadataRuleError, \_PhpScoperb75b35f52b74\PHPStan\Rules\NonIgnorableRuleError
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
