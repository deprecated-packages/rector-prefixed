<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeManipulator;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a2ac50786fa\Rector\NetteKdyby\ValueObject\NetteEventToContributeEventClass;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->valueResolver = $valueResolver;
    }
    public function change(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_ $array) : void
    {
        $arrayItems = \array_filter($array->items, function (\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem $arrayItem) : bool {
            return $arrayItem !== null;
        });
        $this->callableNodeTraverser->traverseNodesWithCallable($arrayItems, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?Node {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem) {
                return null;
            }
            foreach (\_PhpScoper0a2ac50786fa\Rector\NetteKdyby\ValueObject\NetteEventToContributeEventClass::PROPERTY_TO_EVENT_CLASS as $netteEventProperty => $contributeEventClass) {
                if ($node->key === null) {
                    continue;
                }
                if (!$this->valueResolver->isValue($node->key, $netteEventProperty)) {
                    continue;
                }
                $node->key = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified($contributeEventClass), 'class');
            }
            return $node;
        });
    }
}
