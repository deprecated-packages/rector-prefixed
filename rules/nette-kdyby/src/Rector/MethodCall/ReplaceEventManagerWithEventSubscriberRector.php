<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteKdyby\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NetteKdyby\Naming\EventClassNaming;
use _PhpScoper0a6b37af0871\Rector\NetteKdyby\NodeFactory\EventValueObjectClassFactory;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector\ReplaceEventManagerWithEventSubscriberRectorTest
 */
final class ReplaceEventManagerWithEventSubscriberRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var EventClassNaming
     */
    private $eventClassNaming;
    /**
     * @var EventValueObjectClassFactory
     */
    private $eventValueObjectClassFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NetteKdyby\Naming\EventClassNaming $eventClassNaming, \_PhpScoper0a6b37af0871\Rector\NetteKdyby\NodeFactory\EventValueObjectClassFactory $eventValueObjectClassFactory)
    {
        $this->eventClassNaming = $eventClassNaming;
        $this->eventValueObjectClassFactory = $eventValueObjectClassFactory;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change Kdyby EventManager to EventDispatcher', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Kdyby\Events\EventManager;

final class SomeClass
{
    /**
     * @var EventManager
     */
    private $eventManager;

    public function __construct(EventManager $eventManager)
    {
        $this->eventManager = eventManager;
    }

    public function run()
    {
        $key = '2000';
        $this->eventManager->dispatchEvent(static::class . '::onCopy', new EventArgsList([$this, $key]));
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Kdyby\Events\EventManager;

final class SomeClass
{
    /**
     * @var EventManager
     */
    private $eventManager;

    public function __construct(EventManager $eventManager)
    {
        $this->eventManager = eventManager;
    }

    public function run()
    {
        $key = '2000';
        $this->eventManager->dispatch(new SomeClassCopyEvent($this, $key));
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $node->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier('dispatch');
        $oldArgs = $node->args;
        $node->args = [];
        $eventReference = $oldArgs[0]->value;
        $classAndStaticProperty = $this->getValue($eventReference, \true);
        $eventClassName = $this->eventClassNaming->createEventClassNameFromClassPropertyReference($classAndStaticProperty);
        $args = $this->createNewArgs($oldArgs);
        $new = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($eventClassName), $args);
        $node->args[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($new);
        // 3. create new event class with args
        $eventClassInNamespace = $this->eventValueObjectClassFactory->create($eventClassName, $args);
        /** @var SmartFileInfo|null $fileInfo */
        $fileInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($fileInfo === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        $eventFileLocation = $this->eventClassNaming->resolveEventFileLocationFromClassNameAndFileInfo($eventClassName, $fileInfo);
        $this->printNodesToFilePath([$eventClassInNamespace], $eventFileLocation);
        return $node;
    }
    private function shouldSkip(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if (!$this->isObjectType($methodCall->var, '_PhpScoper0a6b37af0871\\Kdyby\\Events\\EventManager')) {
            return \true;
        }
        return !$this->isName($methodCall->name, 'dispatchEvent');
    }
    /**
     * @param Arg[] $oldArgs
     * @return Arg[]
     */
    private function createNewArgs(array $oldArgs) : array
    {
        $args = [];
        if ($oldArgs[1]->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_) {
            /** @var New_ $new */
            $new = $oldArgs[1]->value;
            $array = $new->args[0]->value;
            if (!$array instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_) {
                return [];
            }
            foreach ($array->items as $arrayItem) {
                if (!$arrayItem instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem) {
                    continue;
                }
                $args[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($arrayItem->value);
            }
        }
        return $args;
    }
}
