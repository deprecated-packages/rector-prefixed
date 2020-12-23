<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteKdyby\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\Rector\NetteKdyby\DataProvider\EventAndListenerTreeProvider;
use _PhpScoper0a2ac50786fa\Rector\NetteKdyby\Naming\EventClassNaming;
use _PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeManipulator\ListeningClassMethodArgumentManipulator;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteKdyby\Tests\Rector\ClassMethod\ReplaceMagicEventPropertySubscriberWithEventClassSubscriberRector\ReplaceMagicEventPropertySubscriberWithEventClassSubscriberRectorTest
 */
final class ReplaceMagicEventPropertySubscriberWithEventClassSubscriberRector extends \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\Rector\ClassMethod\AbstractKdybyEventSubscriberRector
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NetteKdyby\DataProvider\EventAndListenerTreeProvider $eventAndListenerTreeProvider, \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\Naming\EventClassNaming $eventClassNaming, \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeManipulator\ListeningClassMethodArgumentManipulator $listeningClassMethodArgumentManipulator)
    {
        $this->eventClassNaming = $eventClassNaming;
        $this->listeningClassMethodArgumentManipulator = $listeningClassMethodArgumentManipulator;
        $this->eventAndListenerTreeProvider = $eventAndListenerTreeProvider;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change getSubscribedEvents() from on magic property, to Event class', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        $this->replaceEventPropertyReferenceWithEventClassReference($node);
        $eventAndListenerTrees = $this->eventAndListenerTreeProvider->provide();
        /** @var string $className */
        $className = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        foreach ($eventAndListenerTrees as $eventAndListenerTree) {
            $this->listeningClassMethodArgumentManipulator->changeFromEventAndListenerTreeAndCurrentClassName($eventAndListenerTree, $className);
        }
        return $node;
    }
    private function replaceEventPropertyReferenceWithEventClassReference(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem) {
                return null;
            }
            $arrayKey = $node->key;
            if ($arrayKey === null) {
                return null;
            }
            $eventPropertyReferenceName = $this->getValue($arrayKey);
            // is property?
            if (!\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::contains($eventPropertyReferenceName, '::')) {
                return null;
            }
            $eventClassName = $this->eventClassNaming->createEventClassNameFromClassPropertyReference($eventPropertyReferenceName);
            $node->key = $this->createClassConstantReference($eventClassName);
        });
    }
}
