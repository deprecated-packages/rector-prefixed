<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteKdyby\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\NotImplementedException;
use _PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeManipulator\GetSubscribedEventsArrayManipulator;
use _PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeManipulator\ListeningClassMethodArgumentManipulator;
use _PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeResolver\ListeningMethodsCollector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteKdyby\Tests\Rector\ClassMethod\ChangeNetteEventNamesInGetSubscribedEventsRector\ChangeNetteEventNamesInGetSubscribedEventsRectorTest
 */
final class ChangeNetteEventNamesInGetSubscribedEventsRector extends \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\Rector\ClassMethod\AbstractKdybyEventSubscriberRector
{
    /**
     * @var GetSubscribedEventsArrayManipulator
     */
    private $getSubscribedEventsArrayManipulator;
    /**
     * @var ListeningClassMethodArgumentManipulator
     */
    private $listeningClassMethodArgumentManipulator;
    /**
     * @var ListeningMethodsCollector
     */
    private $listeningMethodsCollector;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeManipulator\GetSubscribedEventsArrayManipulator $getSubscribedEventsArrayManipulator, \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeManipulator\ListeningClassMethodArgumentManipulator $listeningClassMethodArgumentManipulator, \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeResolver\ListeningMethodsCollector $listeningMethodsCollector)
    {
        $this->getSubscribedEventsArrayManipulator = $getSubscribedEventsArrayManipulator;
        $this->listeningClassMethodArgumentManipulator = $listeningClassMethodArgumentManipulator;
        $this->listeningMethodsCollector = $listeningMethodsCollector;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change EventSubscriber from Kdyby to Contributte', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Kdyby\Events\Subscriber;
use Nette\Application\Application;
use Nette\Application\UI\Presenter;

class GetApplesSubscriber implements Subscriber
{
    public function getSubscribedEvents()
    {
        return [
            Application::class . '::onShutdown',
        ];
    }

    public function onShutdown(Presenter $presenter)
    {
        $presenterName = $presenter->getName();
        // ...
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Contributte\Events\Extra\Event\Application\ShutdownEvent;
use Kdyby\Events\Subscriber;
use Nette\Application\Application;

class GetApplesSubscriber implements Subscriber
{
    public static function getSubscribedEvents()
    {
        return [
            ShutdownEvent::class => 'onShutdown',
        ];
    }

    public function onShutdown(ShutdownEvent $shutdownEvent)
    {
        $presenter = $shutdownEvent->getPresenter();
        $presenterName = $presenter->getName();
        // ...
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($this->shouldSkipClassMethod($node)) {
            return null;
        }
        $this->makeStatic($node);
        $this->refactorEventNames($node);
        $listeningClassMethods = $this->listeningMethodsCollector->collectFromClassAndGetSubscribedEventClassMethod($node, \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeResolver\ListeningMethodsCollector::EVENT_TYPE_CONTRIBUTTE);
        $this->listeningClassMethodArgumentManipulator->change($listeningClassMethods);
        return $node;
    }
    private function refactorEventNames(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_) {
                return null;
            }
            if ($node->expr === null) {
                return null;
            }
            $returnedExpr = $node->expr;
            if (!$returnedExpr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_) {
                return null;
            }
            $this->refactorArrayWithEventTable($returnedExpr);
            $this->getSubscribedEventsArrayManipulator->change($returnedExpr);
        });
    }
    private function refactorArrayWithEventTable(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_ $array) : void
    {
        foreach ($array->items as $arrayItem) {
            if ($arrayItem === null) {
                continue;
            }
            if ($arrayItem->key !== null) {
                continue;
            }
            $methodName = $this->resolveMethodNameFromKdybyEventName($arrayItem->value);
            $arrayItem->key = $arrayItem->value;
            $arrayItem->value = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($methodName);
        }
    }
    private function resolveMethodNameFromKdybyEventName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : string
    {
        $kdybyEventName = $this->getValue($expr);
        if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::contains($kdybyEventName, '::')) {
            return (string) \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::after($kdybyEventName, '::', -1);
        }
        throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\NotImplementedException($kdybyEventName);
    }
}
