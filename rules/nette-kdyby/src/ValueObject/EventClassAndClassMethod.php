<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteKdyby\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
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
    public function __construct(string $eventClass, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod)
    {
        $this->eventClass = $eventClass;
        $this->classMethod = $classMethod;
    }
    public function getEventClass() : string
    {
        return $this->eventClass;
    }
    public function getClassMethod() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        return $this->classMethod;
    }
}
