<?php

declare (strict_types=1);
namespace Rector\SymfonyCodeQuality\ValueObject;

use PhpParser\Node\Expr\ClassConstFetch;
use Rector\SymfonyCodeQuality\Contract\EventReferenceToMethodNameInterface;
final class EventReferenceToMethodNameWithPriority implements \Rector\SymfonyCodeQuality\Contract\EventReferenceToMethodNameInterface
{
    /**
     * @var ClassConstFetch
     */
    private $classConstFetch;
    /**
     * @var string
     */
    private $methodName;
    /**
     * @var int
     */
    private $priority;
    public function __construct(\PhpParser\Node\Expr\ClassConstFetch $classConstFetch, string $methodName, int $priority)
    {
        $this->classConstFetch = $classConstFetch;
        $this->methodName = $methodName;
        $this->priority = $priority;
    }
    public function getClassConstFetch() : \PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->classConstFetch;
    }
    public function getMethodName() : string
    {
        return $this->methodName;
    }
    public function getPriority() : int
    {
        return $this->priority;
    }
}
