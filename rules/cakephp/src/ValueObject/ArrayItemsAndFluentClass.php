<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem;
final class ArrayItemsAndFluentClass
{
    /**
     * @var ArrayItem[]
     */
    private $arrayItems = [];
    /**
     * @var array<string, Expr>
     */
    private $fluentCalls = [];
    /**
     * @param ArrayItem[] $arrayItems
     * @param array<string, Expr> $fluentCalls
     */
    public function __construct(array $arrayItems, array $fluentCalls)
    {
        $this->arrayItems = $arrayItems;
        $this->fluentCalls = $fluentCalls;
    }
    /**
     * @return ArrayItem[]
     */
    public function getArrayItems() : array
    {
        return $this->arrayItems;
    }
    /**
     * @return array<string, Expr>
     */
    public function getFluentCalls() : array
    {
        return $this->fluentCalls;
    }
}
