<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteToSymfony\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\Composer\Script\Event;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NetteToSymfony\Event\EventInfosFactory;
use _PhpScoper0a2ac50786fa\Rector\NetteToSymfony\ValueObject\EventInfo;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/contributte/event-dispatcher-extra/blob/master/.docs/README.md#bridge-wrench
 * @see https://symfony.com/doc/current/reference/events.html
 * @see https://symfony.com/doc/current/components/http_kernel.html#creating-an-event-listener
 * @see https://github.com/symfony/symfony/blob/master/src/Symfony/Component/HttpKernel/KernelEvents.php
 * @see \Rector\NetteToSymfony\Tests\Rector\ClassMethod\RenameEventNamesInEventSubscriberRector\RenameEventNamesInEventSubscriberRectorTest
 */
final class RenameEventNamesInEventSubscriberRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var EventInfo[]
     */
    private $symfonyClassConstWithAliases = [];
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NetteToSymfony\Event\EventInfosFactory $eventInfosFactory)
    {
        $this->symfonyClassConstWithAliases = $eventInfosFactory->create();
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes event names from Nette ones to Symfony ones', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class SomeClass implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return ['nette.application' => 'someMethod'];
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class SomeClass implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [\SymfonyEvents::KERNEL => 'someMethod'];
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
        $classLike = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return null;
        }
        if (!$this->isObjectType($classLike, '_PhpScoper0a2ac50786fa\\Symfony\\Component\\EventDispatcher\\EventSubscriberInterface')) {
            return null;
        }
        if (!$this->isName($node, 'getSubscribedEvents')) {
            return null;
        }
        /** @var Return_[] $returnNodes */
        $returnNodes = $this->betterNodeFinder->findInstanceOf($node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_::class);
        foreach ($returnNodes as $returnNode) {
            if (!$returnNode->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_) {
                continue;
            }
            $this->renameArrayKeys($returnNode);
        }
        return $node;
    }
    private function renameArrayKeys(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_ $return) : void
    {
        if (!$return->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_) {
            return;
        }
        foreach ($return->expr->items as $arrayItem) {
            if ($arrayItem === null) {
                continue;
            }
            $eventInfo = $this->matchStringKeys($arrayItem);
            if ($eventInfo === null) {
                $eventInfo = $this->matchClassConstKeys($arrayItem);
            }
            if ($eventInfo === null) {
                continue;
            }
            $arrayItem->key = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified($eventInfo->getClass()), $eventInfo->getConstant());
            // method name
            $className = (string) $return->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            $methodName = (string) $this->getValue($arrayItem->value);
            $this->processMethodArgument($className, $methodName, $eventInfo);
        }
    }
    private function matchStringKeys(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem $arrayItem) : ?\_PhpScoper0a2ac50786fa\Rector\NetteToSymfony\ValueObject\EventInfo
    {
        if (!$arrayItem->key instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            return null;
        }
        foreach ($this->symfonyClassConstWithAliases as $symfonyClassConst) {
            foreach ($symfonyClassConst->getOldStringAliases() as $netteStringName) {
                if ($this->isValue($arrayItem->key, $netteStringName)) {
                    return $symfonyClassConst;
                }
            }
        }
        return null;
    }
    private function matchClassConstKeys(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem $arrayItem) : ?\_PhpScoper0a2ac50786fa\Rector\NetteToSymfony\ValueObject\EventInfo
    {
        if (!$arrayItem->key instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch) {
            return null;
        }
        foreach ($this->symfonyClassConstWithAliases as $symfonyClassConst) {
            $isMatch = $this->resolveClassConstAliasMatch($arrayItem, $symfonyClassConst);
            if ($isMatch) {
                return $symfonyClassConst;
            }
        }
        return null;
    }
    private function processMethodArgument(string $class, string $method, \_PhpScoper0a2ac50786fa\Rector\NetteToSymfony\ValueObject\EventInfo $eventInfo) : void
    {
        $classMethodNode = $this->nodeRepository->findClassMethod($class, $method);
        if ($classMethodNode === null) {
            return;
        }
        if (\count((array) $classMethodNode->params) !== 1) {
            return;
        }
        $classMethodNode->params[0]->type = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified($eventInfo->getEventClass());
    }
    private function resolveClassConstAliasMatch(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem $arrayItem, \_PhpScoper0a2ac50786fa\Rector\NetteToSymfony\ValueObject\EventInfo $eventInfo) : bool
    {
        foreach ($eventInfo->getOldClassConstAliases() as $netteClassConst) {
            $classConstFetchNode = $arrayItem->key;
            if ($classConstFetchNode === null) {
                continue;
            }
            if ($this->isName($classConstFetchNode, $netteClassConst)) {
                return \true;
            }
        }
        return \false;
    }
}
