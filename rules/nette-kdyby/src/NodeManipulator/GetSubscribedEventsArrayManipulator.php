<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteKdyby\NodeManipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\NetteKdyby\ValueObject\NetteEventToContributeEventClass;
final class GetSubscribedEventsArrayManipulator
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->valueResolver = $valueResolver;
    }
    public function change(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_ $array) : void
    {
        $arrayItems = \array_filter($array->items, function (\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem $arrayItem) : bool {
            return $arrayItem !== null;
        });
        $this->callableNodeTraverser->traverseNodesWithCallable($arrayItems, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : ?Node {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem) {
                return null;
            }
            foreach (\_PhpScopere8e811afab72\Rector\NetteKdyby\ValueObject\NetteEventToContributeEventClass::PROPERTY_TO_EVENT_CLASS as $netteEventProperty => $contributeEventClass) {
                if ($node->key === null) {
                    continue;
                }
                if (!$this->valueResolver->isValue($node->key, $netteEventProperty)) {
                    continue;
                }
                $node->key = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($contributeEventClass), 'class');
            }
            return $node;
        });
    }
}
