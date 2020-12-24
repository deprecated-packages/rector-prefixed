<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteKdyby\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
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
    public function __construct(string $eventClass, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod)
    {
        $this->eventClass = $eventClass;
        $this->classMethod = $classMethod;
    }
    public function getEventClass() : string
    {
        return $this->eventClass;
    }
    public function getClassMethod() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        return $this->classMethod;
    }
}
