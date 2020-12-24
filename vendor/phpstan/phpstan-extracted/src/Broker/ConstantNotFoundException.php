<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Broker;

class ConstantNotFoundException extends \_PhpScoper0a6b37af0871\PHPStan\AnalysedCodeException
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
