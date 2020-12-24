<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\Rector\Array_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/SG0Wu
 * @see \Rector\DeadCode\Tests\Rector\Array_\RemoveDuplicatedArrayKeyRector\RemoveDuplicatedArrayKeyRectorTest
 */
final class RemoveDuplicatedArrayKeyRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove duplicated key in defined arrays.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_::class];
    }
    /**
     * @param Array_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
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
    private function getArrayItemsWithDuplicatedKey(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_ $array) : array
    {
        $arrayItemsByKeys = [];
        foreach ($array->items as $arrayItem) {
            if (!$arrayItem instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem) {
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
