<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
final class StaticCallAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isParentCallNamed(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $desiredMethodName) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        if ($node->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node->class, 'parent')) {
            return \false;
        }
        if ($node->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node->name, $desiredMethodName);
    }
}
