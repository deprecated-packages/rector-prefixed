<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
final class DataProviderClassMethodRecipe
{
    /**
     * @var string
     */
    private $methodName;
    /**
     * @var Arg[]
     */
    private $args = [];
    /**
     * @param Arg[] $args
     */
    public function __construct(string $methodName, array $args)
    {
        $this->methodName = $methodName;
        $this->args = $args;
    }
    public function getMethodName() : string
    {
        return $this->methodName;
    }
    /**
     * @return Arg[]
     */
    public function getArgs() : array
    {
        return $this->args;
    }
}
