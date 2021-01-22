<?php

declare (strict_types=1);
namespace Rector\SymfonyCodeQuality\NodeFactory;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use Rector\Core\Php\PhpVersionProvider;
use Rector\Core\PhpParser\Node\Manipulator\VisibilityManipulator;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\Symfony\Contract\Tag\TagInterface;
use Rector\Symfony\ValueObject\ServiceDefinition;
use Rector\Symfony\ValueObject\Tag;
use Rector\Symfony\ValueObject\Tag\EventListenerTag;
use Rector\SymfonyCodeQuality\ValueObject\EventNameToClassAndConstant;
final class GetSubscriberEventsClassMethodFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var VisibilityManipulator
     */
    private $visibilityManipulator;
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    /**
     * @var PhpDocTypeChanger
     */
    private $phpDocTypeChanger;
    public function __construct(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\Core\PhpParser\Node\Manipulator\VisibilityManipulator $visibilityManipulator, \Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger $phpDocTypeChanger)
    {
        $this->nodeFactory = $nodeFactory;
        $this->visibilityManipulator = $visibilityManipulator;
        $this->phpVersionProvider = $phpVersionProvider;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->phpDocTypeChanger = $phpDocTypeChanger;
    }
    /**
     * @param array<string, ServiceDefinition[]> $eventsToMethods
     * @param EventNameToClassAndConstant[] $eventNamesToClassConstants
     */
    public function createFromEventsToMethods(array $eventsToMethods, array $eventNamesToClassConstants) : \PhpParser\Node\Stmt\ClassMethod
    {
        $getSubscribersClassMethod = $this->nodeFactory->createPublicMethod('getSubscribedEvents');
        $eventsToMethodsArray = new \PhpParser\Node\Expr\Array_();
        $this->visibilityManipulator->makeStatic($getSubscribersClassMethod);
        foreach ($eventsToMethods as $eventName => $methodNamesWithPriorities) {
            $eventNameExpr = $this->createEventName($eventName, $eventNamesToClassConstants);
            if (\count($methodNamesWithPriorities) === 1) {
                $this->createSingleMethod($methodNamesWithPriorities, $eventName, $eventNameExpr, $eventsToMethodsArray);
            } else {
                $this->createMultipleMethods($methodNamesWithPriorities, $eventNameExpr, $eventsToMethodsArray, $eventName);
            }
        }
        $getSubscribersClassMethod->stmts[] = new \PhpParser\Node\Stmt\Return_($eventsToMethodsArray);
        $this->decorateClassMethodWithReturnType($getSubscribersClassMethod);
        return $getSubscribersClassMethod;
    }
    /**
     * @param EventNameToClassAndConstant[] $eventNamesToClassConstants
     * @return String_|ClassConstFetch
     */
    private function createEventName(string $eventName, array $eventNamesToClassConstants) : \PhpParser\Node
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
    /**
     * @param ClassConstFetch|String_ $expr
     * @param ServiceDefinition[] $methodNamesWithPriorities
     */
    private function createSingleMethod(array $methodNamesWithPriorities, string $eventName, \PhpParser\Node\Expr $expr, \PhpParser\Node\Expr\Array_ $eventsToMethodsArray) : void
    {
        /** @var EventListenerTag[]|Tag[] $eventTags */
        $eventTags = $methodNamesWithPriorities[0]->getTags();
        foreach ($eventTags as $eventTag) {
            if ($eventTag instanceof \Rector\Symfony\ValueObject\Tag\EventListenerTag && $eventTag->getEvent() === $eventName) {
                $methodName = $eventTag->getMethod();
                $priority = $eventTag->getPriority();
                break;
            }
        }
        if (!isset($methodName, $priority)) {
            return;
        }
        if ($priority !== 0) {
            $methodNameWithPriorityArray = new \PhpParser\Node\Expr\Array_();
            $methodNameWithPriorityArray->items[] = new \PhpParser\Node\Expr\ArrayItem(new \PhpParser\Node\Scalar\String_($methodName));
            $methodNameWithPriorityArray->items[] = new \PhpParser\Node\Expr\ArrayItem(new \PhpParser\Node\Scalar\LNumber((int) $priority));
            $eventsToMethodsArray->items[] = new \PhpParser\Node\Expr\ArrayItem($methodNameWithPriorityArray, $expr);
        } else {
            $eventsToMethodsArray->items[] = new \PhpParser\Node\Expr\ArrayItem(new \PhpParser\Node\Scalar\String_($methodName), $expr);
        }
    }
    /**
     * @param ClassConstFetch|String_ $expr
     * @param ServiceDefinition[] $methodNamesWithPriorities
     */
    private function createMultipleMethods(array $methodNamesWithPriorities, \PhpParser\Node\Expr $expr, \PhpParser\Node\Expr\Array_ $eventsToMethodsArray, string $eventName) : void
    {
        $eventItems = [];
        $alreadyUsedTags = [];
        foreach ($methodNamesWithPriorities as $methodNamesWithPriority) {
            foreach ($methodNamesWithPriority->getTags() as $tag) {
                if (!$tag instanceof \Rector\Symfony\ValueObject\Tag\EventListenerTag) {
                    continue;
                }
                if ($this->shouldSkip($eventName, $tag, $alreadyUsedTags)) {
                    continue;
                }
                $eventItems[] = $this->createEventItem($tag);
                $alreadyUsedTags[] = $tag;
            }
        }
        $multipleMethodsArray = new \PhpParser\Node\Expr\Array_($eventItems);
        $eventsToMethodsArray->items[] = new \PhpParser\Node\Expr\ArrayItem($multipleMethodsArray, $expr);
    }
    private function decorateClassMethodWithReturnType(\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            $classMethod->returnType = new \PhpParser\Node\Identifier('array');
        }
        $returnType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType(\true));
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        $this->phpDocTypeChanger->changeReturnType($phpDocInfo, $returnType);
    }
    /**
     * @param TagInterface[] $alreadyUsedTags
     */
    private function shouldSkip(string $eventName, \Rector\Symfony\ValueObject\Tag\EventListenerTag $eventListenerTag, array $alreadyUsedTags) : bool
    {
        if ($eventName !== $eventListenerTag->getEvent()) {
            return \true;
        }
        return \in_array($eventListenerTag, $alreadyUsedTags, \true);
    }
    private function createEventItem(\Rector\Symfony\ValueObject\Tag\EventListenerTag $eventListenerTag) : \PhpParser\Node\Expr\ArrayItem
    {
        if ($eventListenerTag->getPriority() !== 0) {
            $methodNameWithPriorityArray = new \PhpParser\Node\Expr\Array_();
            $methodNameWithPriorityArray->items[] = new \PhpParser\Node\Expr\ArrayItem(new \PhpParser\Node\Scalar\String_($eventListenerTag->getMethod()));
            $methodNameWithPriorityArray->items[] = new \PhpParser\Node\Expr\ArrayItem(new \PhpParser\Node\Scalar\LNumber($eventListenerTag->getPriority()));
            return new \PhpParser\Node\Expr\ArrayItem($methodNameWithPriorityArray);
        }
        return new \PhpParser\Node\Expr\ArrayItem(new \PhpParser\Node\Scalar\String_($eventListenerTag->getMethod()));
    }
}
