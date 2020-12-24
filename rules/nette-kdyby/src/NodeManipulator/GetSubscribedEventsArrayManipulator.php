<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteKdyby\NodeManipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoperb75b35f52b74\Rector\NetteKdyby\ValueObject\NetteEventToContributeEventClass;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->valueResolver = $valueResolver;
    }
    public function change(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_ $array) : void
    {
        $arrayItems = \array_filter($array->items, function (\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem $arrayItem) : bool {
            return $arrayItem !== null;
        });
        $this->callableNodeTraverser->traverseNodesWithCallable($arrayItems, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?Node {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem) {
                return null;
            }
            foreach (\_PhpScoperb75b35f52b74\Rector\NetteKdyby\ValueObject\NetteEventToContributeEventClass::PROPERTY_TO_EVENT_CLASS as $netteEventProperty => $contributeEventClass) {
                if ($node->key === null) {
                    continue;
                }
                if (!$this->valueResolver->isValue($node->key, $netteEventProperty)) {
                    continue;
                }
                $node->key = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($contributeEventClass), 'class');
            }
            return $node;
        });
    }
}
