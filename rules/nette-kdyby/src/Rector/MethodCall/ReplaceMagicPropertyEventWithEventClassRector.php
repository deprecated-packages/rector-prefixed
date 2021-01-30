<?php

declare (strict_types=1);
namespace Rector\NetteKdyby\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use Rector\CodingStyle\Naming\ClassNaming;
use Rector\Core\Rector\AbstractRector;
use Rector\NetteKdyby\DataProvider\EventAndListenerTreeProvider;
use Rector\NetteKdyby\ValueObject\EventAndListenerTree;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use RectorPrefix20210130\Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\ReplaceMagicPropertyEventWithEventClassRectorTest
 */
final class ReplaceMagicPropertyEventWithEventClassRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var EventAndListenerTreeProvider
     */
    private $eventAndListenerTreeProvider;
    public function __construct(\Rector\CodingStyle\Naming\ClassNaming $classNaming, \Rector\NetteKdyby\DataProvider\EventAndListenerTreeProvider $eventAndListenerTreeProvider)
    {
        $this->classNaming = $classNaming;
        $this->eventAndListenerTreeProvider = $eventAndListenerTreeProvider;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change $onProperty magic call with event disptacher and class dispatch', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class FileManager
{
    public $onUpload;

    public function run(User $user)
    {
        $this->onUpload($user);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class FileManager
{
    use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function run(User $user)
    {
        $onFileManagerUploadEvent = new FileManagerUploadEvent($user);
        $this->eventDispatcher->dispatch($onFileManagerUploadEvent);
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
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        // 1. is onProperty? call
        $eventAndListenerTree = $this->eventAndListenerTreeProvider->matchMethodCall($node);
        if (!$eventAndListenerTree instanceof \Rector\NetteKdyby\ValueObject\EventAndListenerTree) {
            return null;
        }
        // 2. guess event name
        $eventClassName = $eventAndListenerTree->getEventClassName();
        // 3. create new event class with args
        $eventClassInNamespace = $eventAndListenerTree->getEventClassInNamespace();
        $this->printNodesToFilePath([$eventClassInNamespace], $eventAndListenerTree->getEventFileLocation());
        // 4. ad dispatch method call
        $dispatchMethodCall = $eventAndListenerTree->getEventDispatcherDispatchMethodCall();
        $this->addNodeAfterNode($dispatchMethodCall, $node);
        // 5. return event adding
        // add event dispatcher dependency if needed
        $assign = $this->createEventInstanceAssign($eventClassName, $node);
        /** @var Class_ $classLike */
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        $this->addConstructorDependencyToClass($classLike, new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType(\RectorPrefix20210130\Symfony\Contracts\EventDispatcher\EventDispatcherInterface::class), 'eventDispatcher');
        // 6. remove property
        if ($eventAndListenerTree->getOnMagicProperty() !== null) {
            $this->removeNode($eventAndListenerTree->getOnMagicProperty());
        }
        return $assign;
    }
    private function createEventInstanceAssign(string $eventClassName, \PhpParser\Node\Expr\MethodCall $methodCall) : \PhpParser\Node\Expr\Assign
    {
        $shortEventClassName = $this->classNaming->getVariableName($eventClassName);
        $new = new \PhpParser\Node\Expr\New_(new \PhpParser\Node\Name\FullyQualified($eventClassName));
        if ($methodCall->args) {
            $new->args = $methodCall->args;
        }
        return new \PhpParser\Node\Expr\Assign(new \PhpParser\Node\Expr\Variable($shortEventClassName), $new);
    }
}
