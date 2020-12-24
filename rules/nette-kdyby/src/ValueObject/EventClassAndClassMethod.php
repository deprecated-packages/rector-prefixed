<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteKdyby\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
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
    public function __construct(string $eventClass, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod)
    {
        $this->eventClass = $eventClass;
        $this->classMethod = $classMethod;
    }
    public function getEventClass() : string
    {
        return $this->eventClass;
    }
    public function getClassMethod() : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        return $this->classMethod;
    }
}
