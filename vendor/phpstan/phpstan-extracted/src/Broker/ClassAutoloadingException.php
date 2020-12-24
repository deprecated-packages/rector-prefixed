<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Broker;

class ClassAutoloadingException extends \_PhpScoper0a6b37af0871\PHPStan\AnalysedCodeException
{
    /** @var string */
    private $className;
    public function __construct(string $functionName, ?\Throwable $previous = null)
    {
        if ($previous !== null) {
            parent::__construct(\sprintf('%s (%s) thrown while looking for class %s.', \get_class($previous), $previous->getMessage(), $functionName), 0, $previous);
        } else {
            parent::__construct(\sprintf('Class %s not found.', $functionName), 0);
        }
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
