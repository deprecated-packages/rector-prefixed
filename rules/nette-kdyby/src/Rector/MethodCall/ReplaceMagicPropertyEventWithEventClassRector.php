<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteKdyby\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NetteKdyby\DataProvider\EventAndListenerTreeProvider;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\ReplaceMagicPropertyEventWithEventClassRectorTest
 */
final class ReplaceMagicPropertyEventWithEventClassRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var EventAndListenerTreeProvider
     */
    private $eventAndListenerTreeProvider;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScoperb75b35f52b74\Rector\NetteKdyby\DataProvider\EventAndListenerTreeProvider $eventAndListenerTreeProvider)
    {
        $this->classNaming = $classNaming;
        $this->eventAndListenerTreeProvider = $eventAndListenerTreeProvider;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change $onProperty magic call with event disptacher and class dispatch', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        // 1. is onProperty? call
        $eventAndListenerTree = $this->eventAndListenerTreeProvider->matchMethodCall($node);
        if ($eventAndListenerTree === null) {
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
        $classLike = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        $this->addConstructorDependencyToClass($classLike, new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType(\_PhpScoperb75b35f52b74\Symfony\Contracts\EventDispatcher\EventDispatcherInterface::class), 'eventDispatcher');
        // 6. remove property
        if ($eventAndListenerTree->getOnMagicProperty() !== null) {
            $this->removeNode($eventAndListenerTree->getOnMagicProperty());
        }
        return $assign;
    }
    private function createEventInstanceAssign(string $eventClassName, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign
    {
        $shortEventClassName = $this->classNaming->getVariableName($eventClassName);
        $new = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($eventClassName));
        if ($methodCall->args) {
            $new->args = $methodCall->args;
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($shortEventClassName), $new);
    }
}
