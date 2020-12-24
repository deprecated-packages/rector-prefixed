<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\Rector\Array_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/SG0Wu
 * @see \Rector\DeadCode\Tests\Rector\Array_\RemoveDuplicatedArrayKeyRector\RemoveDuplicatedArrayKeyRectorTest
 */
final class RemoveDuplicatedArrayKeyRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove duplicated key in defined arrays.', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$item = [
    1 => 'A',
    1 => 'B'
];
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$item = [
    1 => 'B'
];
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_::class];
    }
    /**
     * @param Array_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $arrayItemsWithDuplicatedKey = $this->getArrayItemsWithDuplicatedKey($node);
        if ($arrayItemsWithDuplicatedKey === []) {
            return null;
        }
        foreach ($arrayItemsWithDuplicatedKey as $arrayItems) {
            // keep last item
            \array_pop($arrayItems);
            $this->removeNodes($arrayItems);
        }
        return $node;
    }
    /**
     * @return ArrayItem[][]
     */
    private function getArrayItemsWithDuplicatedKey(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_ $array) : array
    {
        $arrayItemsByKeys = [];
        foreach ($array->items as $arrayItem) {
            if (!$arrayItem instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem) {
                continue;
            }
            if ($arrayItem->key === null) {
                continue;
            }
            $keyValue = $this->print($arrayItem->key);
            $arrayItemsByKeys[$keyValue][] = $arrayItem;
        }
        return $this->filterItemsWithSameKey($arrayItemsByKeys);
    }
    /**
     * @param ArrayItem[][] $arrayItemsByKeys
     * @return ArrayItem[][]
     */
    private function filterItemsWithSameKey(array $arrayItemsByKeys) : array
    {
        $arrayItemsByKeys = \array_filter($arrayItemsByKeys, function (array $arrayItems) : bool {
            return \count($arrayItems) > 1;
        });
        /** @var ArrayItem[][] $arrayItemsByKeys */
        return $arrayItemsByKeys;
    }
}
