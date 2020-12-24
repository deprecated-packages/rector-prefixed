<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError31 implements \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleError, \_PhpScoperb75b35f52b74\PHPStan\Rules\LineRuleError, \_PhpScoperb75b35f52b74\PHPStan\Rules\FileRuleError, \_PhpScoperb75b35f52b74\PHPStan\Rules\TipRuleError, \_PhpScoperb75b35f52b74\PHPStan\Rules\IdentifierRuleError
{
    /** @var string */
    public $message;
    /** @var int */
    public $line;
    /** @var string */
    public $file;
    /** @var string */
    public $tip;
    /** @var string */
    public $identifier;
    public function getMessage() : string
    {
        return $this->message;
    }
    public function getLine() : int
    {
        return $this->line;
    }
    public function getFile() : string
    {
        return $this->file;
    }
    public function getTip() : string
    {
        return $this->tip;
    }
    public function getIdentifier() : string
    {
        return $this->identifier;
    }
}
