<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby\NodeManipulator;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby\ValueObject\NetteEventToContributeEventClass;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->valueResolver = $valueResolver;
    }
    public function change(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_ $array) : void
    {
        $arrayItems = \array_filter($array->items, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem $arrayItem) : bool {
            return $arrayItem !== null;
        });
        $this->callableNodeTraverser->traverseNodesWithCallable($arrayItems, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?Node {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem) {
                return null;
            }
            foreach (\_PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby\ValueObject\NetteEventToContributeEventClass::PROPERTY_TO_EVENT_CLASS as $netteEventProperty => $contributeEventClass) {
                if ($node->key === null) {
                    continue;
                }
                if (!$this->valueResolver->isValue($node->key, $netteEventProperty)) {
                    continue;
                }
                $node->key = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified($contributeEventClass), 'class');
            }
            return $node;
        });
    }
}
