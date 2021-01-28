<?php

declare (strict_types=1);
namespace Rector\SymfonyCodeQuality\NodeFactory;

use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Scalar\String_;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\SymfonyCodeQuality\ValueObject\EventNameToClassAndConstant;
final class EventReferenceFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
    }
    /**
     * @param EventNameToClassAndConstant[] $eventNamesToClassConstants
     * @return String_|ClassConstFetch
     */
    public function createEventName(string $eventName, array $eventNamesToClassConstants) : \PhpParser\Node
    {
        if (\class_exists($eventName)) {
            return $this->nodeFactory->createClassConstReference($eventName);
        }
        // is string a that could be caught in constant, e.g. KernelEvents?
        foreach ($eventNamesToClassConstants as $eventNameToClassConstant) {
            if ($eventNameToClassConstant->getEventName() !== $eventName) {
                continue;
            }
            return $this->nodeFactory->createClassConstFetch($eventNameToClassConstant->getEventClass(), $eventNameToClassConstant->getEventConstant());
        }
        return new \PhpParser\Node\Scalar\String_($eventName);
    }
}
