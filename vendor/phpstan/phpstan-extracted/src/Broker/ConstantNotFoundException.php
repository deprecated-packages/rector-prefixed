<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Broker;

class ConstantNotFoundException extends \_PhpScoperb75b35f52b74\PHPStan\AnalysedCodeException
{
    /** @var string */
    private $constantName;
    public function __construct(string $constantName)
    {
        parent::__construct(\sprintf('Constant %s not found.', $constantName));
        $this->constantName = $constantName;
    }
    public function getConstantName() : string
    {
        return $this->constantName;
    }
    public function getTip() : ?string
    {
        return 'Learn more at https://phpstan.org/user-guide/discovering-symbols';
    }
}
