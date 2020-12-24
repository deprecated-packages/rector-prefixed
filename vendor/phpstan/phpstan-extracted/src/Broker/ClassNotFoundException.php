<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Broker;

class ClassNotFoundException extends \_PhpScoper2a4e7ab1ecbc\PHPStan\AnalysedCodeException
{
    /** @var string */
    private $className;
    public function __construct(string $functionName)
    {
        parent::__construct(\sprintf('Class %s was not found while trying to analyse it - discovering symbols is probably not configured properly.', $functionName));
        $this->className = $functionName;
    }
    public function getClassName() : string
    {
        return $this->className;
    }
    public function getTip() : ?string
    {
        return 'Learn more at https://phpstan.org/user-guide/discovering-symbols';
    }
}
