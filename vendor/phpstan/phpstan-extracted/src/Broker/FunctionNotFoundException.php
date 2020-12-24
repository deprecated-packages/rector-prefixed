<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Broker;

class FunctionNotFoundException extends \_PhpScoperb75b35f52b74\PHPStan\AnalysedCodeException
{
    /** @var string */
    private $functionName;
    public function __construct(string $functionName)
    {
        parent::__construct(\sprintf('Function %s not found while trying to analyse it - discovering symbols is probably not configured properly.', $functionName));
        $this->functionName = $functionName;
    }
    public function getFunctionName() : string
    {
        return $this->functionName;
    }
    public function getTip() : ?string
    {
        return 'Learn more at https://phpstan.org/user-guide/discovering-symbols';
    }
}
