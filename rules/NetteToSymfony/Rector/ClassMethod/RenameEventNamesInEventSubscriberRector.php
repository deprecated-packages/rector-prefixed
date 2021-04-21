<?php

declare(strict_types=1);

namespace Rector\NetteToSymfony\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Type\ObjectType;
use Rector\Core\Rector\AbstractRector;
use Rector\NetteToSymfony\ValueObject\EventInfo;
use Rector\NetteToSymfony\ValueObjectFactory\EventInfosFactory;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @changelog https://symfony.com/doc/current/components/http_kernel.html#creating-an-event-listener
 *
 * @see \Rector\Tests\NetteToSymfony\Rector\ClassMethod\RenameEventNamesInEventSubscriberRector\RenameEventNamesInEventSubscriberRectorTest
 */
final class RenameEventNamesInEventSubscriberRector extends AbstractRector
{
    /**
     * @var EventInfo[]
     */
    private $symfonyClassConstWithAliases = [];

    public function __construct(EventInfosFactory $eventInfosFactory)
    {
        $this->symfonyClassConstWithAliases = $eventInfosFactory->create();
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Changes event names from Nette ones to Symfony ones',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class SomeClass implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return ['nette.application' => 'someMethod'];
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class SomeClass implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [\SymfonyEvents::KERNEL => 'someMethod'];
    }
}
CODE_SAMPLE
            ),
            ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [ClassMethod::class];
    }

    /**
     * @param ClassMethod $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        $classLike = $node->getAttribute(AttributeKey::CLASS_NODE);
        if (! $classLike instanceof ClassLike) {
            return null;
        }

        if (! $this->isObjectType(
            $classLike,
            new ObjectType('Symfony\Component\EventDispatcher\EventSubscriberInterface')
        )) {
            return null;
        }

        if (! $this->isName($node, 'getSubscribedEvents')) {
            return null;
        }

        /** @var Return_[] $returnNodes */
        $returnNodes = $this->betterNodeFinder->findInstanceOf($node, Return_::class);

        foreach ($returnNodes as $returnNode) {
            if (! $returnNode->expr instanceof Array_) {
                continue;
            }

            $this->renameArrayKeys($returnNode);
        }

        return $node;
    }

    /**
     * @return void
     */
    private function renameArrayKeys(Return_ $return)
    {
        if (! $return->expr instanceof Array_) {
            return;
        }

        foreach ($return->expr->items as $arrayItem) {
            if ($arrayItem === null) {
                continue;
            }

            $eventInfo = $this->matchStringKeys($arrayItem);
            if (! $eventInfo instanceof EventInfo) {
                $eventInfo = $this->matchClassConstKeys($arrayItem);
            }

            if (! $eventInfo instanceof EventInfo) {
                continue;
            }

            $arrayItem->key = new ClassConstFetch(new FullyQualified(
                $eventInfo->getClass()
            ), $eventInfo->getConstant());

            // method name
            $className = (string) $return->getAttribute(AttributeKey::CLASS_NAME);
            $methodName = (string) $this->valueResolver->getValue($arrayItem->value);
            $this->processMethodArgument($className, $methodName, $eventInfo);
        }
    }

    /**
     * @return \Rector\NetteToSymfony\ValueObject\EventInfo|null
     */
    private function matchStringKeys(ArrayItem $arrayItem)
    {
        if (! $arrayItem->key instanceof String_) {
            return null;
        }

        foreach ($this->symfonyClassConstWithAliases as $symfonyClassConstWithAlias) {
            foreach ($symfonyClassConstWithAlias->getOldStringAliases() as $netteStringName) {
                if ($this->valueResolver->isValue($arrayItem->key, $netteStringName)) {
                    return $symfonyClassConstWithAlias;
                }
            }
        }

        return null;
    }

    /**
     * @return \Rector\NetteToSymfony\ValueObject\EventInfo|null
     */
    private function matchClassConstKeys(ArrayItem $arrayItem)
    {
        if (! $arrayItem->key instanceof ClassConstFetch) {
            return null;
        }

        foreach ($this->symfonyClassConstWithAliases as $symfonyClassConstWithAlias) {
            $isMatch = $this->resolveClassConstAliasMatch($arrayItem, $symfonyClassConstWithAlias);
            if ($isMatch) {
                return $symfonyClassConstWithAlias;
            }
        }

        return null;
    }

    /**
     * @return void
     */
    private function processMethodArgument(string $class, string $method, EventInfo $eventInfo)
    {
        $classMethodNode = $this->nodeRepository->findClassMethod($class, $method);
        if (! $classMethodNode instanceof ClassMethod) {
            return;
        }

        if (count($classMethodNode->params) !== 1) {
            return;
        }

        $classMethodNode->params[0]->type = new FullyQualified($eventInfo->getEventClass());
    }

    private function resolveClassConstAliasMatch(ArrayItem $arrayItem, EventInfo $eventInfo): bool
    {
        $classConstFetchNode = $arrayItem->key;
        if (! $classConstFetchNode instanceof Expr) {
            return false;
        }

        foreach ($eventInfo->getOldClassConstAliases() as $netteClassConst) {
            if ($this->isName($classConstFetchNode, $netteClassConst)) {
                return true;
            }
        }

        return false;
    }
}
