<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteKdyby\ValueObject;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
final class EventClassAndClassMethod
{
    /**
     * @var string
     */
    private $eventClass;
    /**
     * @var ClassMethod
     */
    private $classMethod;
    public function __construct(string $eventClass, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod)
    {
        $this->eventClass = $eventClass;
        $this->classMethod = $classMethod;
    }
    public function getEventClass() : string
    {
        return $this->eventClass;
    }
    public function getClassMethod() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod
    {
        return $this->classMethod;
    }
}
