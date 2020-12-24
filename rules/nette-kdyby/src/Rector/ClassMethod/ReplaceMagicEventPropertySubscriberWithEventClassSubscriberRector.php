<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteKdyby\Rector\ClassMethod;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\NetteKdyby\DataProvider\EventAndListenerTreeProvider;
use _PhpScopere8e811afab72\Rector\NetteKdyby\Naming\EventClassNaming;
use _PhpScopere8e811afab72\Rector\NetteKdyby\NodeManipulator\ListeningClassMethodArgumentManipulator;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteKdyby\Tests\Rector\ClassMethod\ReplaceMagicEventPropertySubscriberWithEventClassSubscriberRector\ReplaceMagicEventPropertySubscriberWithEventClassSubscriberRectorTest
 */
final class ReplaceMagicEventPropertySubscriberWithEventClassSubscriberRector extends \_PhpScopere8e811afab72\Rector\NetteKdyby\Rector\ClassMethod\AbstractKdybyEventSubscriberRector
{
    /**
     * @var EventClassNaming
     */
    private $eventClassNaming;
    /**
     * @var ListeningClassMethodArgumentManipulator
     */
    private $listeningClassMethodArgumentManipulator;
    /**
     * @var EventAndListenerTreeProvider
     */
    private $eventAndListenerTreeProvider;
    public function __construct(\_PhpScopere8e811afab72\Rector\NetteKdyby\DataProvider\EventAndListenerTreeProvider $eventAndListenerTreeProvider, \_PhpScopere8e811afab72\Rector\NetteKdyby\Naming\EventClassNaming $eventClassNaming, \_PhpScopere8e811afab72\Rector\NetteKdyby\NodeManipulator\ListeningClassMethodArgumentManipulator $listeningClassMethodArgumentManipulator)
    {
        $this->eventClassNaming = $eventClassNaming;
        $this->listeningClassMethodArgumentManipulator = $listeningClassMethodArgumentManipulator;
        $this->eventAndListenerTreeProvider = $eventAndListenerTreeProvider;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change getSubscribedEvents() from on magic property, to Event class', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Kdyby\Events\Subscriber;

final class ActionLogEventSubscriber implements Subscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            AlbumService::class . '::onApprove' => 'onAlbumApprove',
        ];
    }

    public function onAlbumApprove(Album $album, int $adminId): void
    {
        $album->play();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Kdyby\Events\Subscriber;

final class ActionLogEventSubscriber implements Subscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            AlbumServiceApproveEvent::class => 'onAlbumApprove',
        ];
    }

    public function onAlbumApprove(AlbumServiceApproveEventAlbum $albumServiceApproveEventAlbum): void
    {
        $album = $albumServiceApproveEventAlbum->getAlbum();
        $album->play();
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkipClassMethod($node)) {
            return null;
        }
        $this->replaceEventPropertyReferenceWithEventClassReference($node);
        $eventAndListenerTrees = $this->eventAndListenerTreeProvider->provide();
        /** @var string $className */
        $className = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        foreach ($eventAndListenerTrees as $eventAndListenerTree) {
            $this->listeningClassMethodArgumentManipulator->changeFromEventAndListenerTreeAndCurrentClassName($eventAndListenerTree, $className);
        }
        return $node;
    }
    private function replaceEventPropertyReferenceWithEventClassReference(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem) {
                return null;
            }
            $arrayKey = $node->key;
            if ($arrayKey === null) {
                return null;
            }
            $eventPropertyReferenceName = $this->getValue($arrayKey);
            // is property?
            if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($eventPropertyReferenceName, '::')) {
                return null;
            }
            $eventClassName = $this->eventClassNaming->createEventClassNameFromClassPropertyReference($eventPropertyReferenceName);
            $node->key = $this->createClassConstantReference($eventClassName);
        });
    }
}
