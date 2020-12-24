<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php74\Rector\FuncCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/deprecations_php_7_4 (not confirmed yet)
 * @see https://3v4l.org/9rLjE
 * @see \Rector\Php74\Tests\Rector\FuncCall\FilterVarToAddSlashesRector\FilterVarToAddSlashesRectorTest
 */
final class FilterVarToAddSlashesRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change filter_var() with slash escaping to addslashes()', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$var= "Satya's here!";
filter_var($var, FILTER_SANITIZE_MAGIC_QUOTES);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$var= "Satya's here!";
addslashes($var);
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isName($node, 'filter_var')) {
            return null;
        }
        if (!isset($node->args[1])) {
            return null;
        }
        if (!$this->isName($node->args[1]->value, 'FILTER_SANITIZE_MAGIC_QUOTES')) {
            return null;
        }
        $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('addslashes');
        unset($node->args[1]);
        return $node;
    }
}
