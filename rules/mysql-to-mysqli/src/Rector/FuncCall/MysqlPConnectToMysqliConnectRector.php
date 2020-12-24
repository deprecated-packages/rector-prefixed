<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\MysqlToMysqli\Rector\FuncCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://stackoverflow.com/a/34041762/1348344
 * @see \Rector\MysqlToMysqli\Tests\Rector\FuncCall\MysqlPConnectToMysqliConnectRector\MysqlPConnectToMysqliConnectRectorTest
 */
final class MysqlPConnectToMysqliConnectRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace mysql_pconnect() with mysqli_connect() with host p: prefix', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run($host, $username, $password)
    {
        return mysql_pconnect($host, $username, $password);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run($host, $username, $password)
    {
        return mysqli_connect('p:' . $host, $username, $password);
    }
}
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
        if (!$this->isName($node, 'mysql_pconnect')) {
            return null;
        }
        $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('mysqli_connect');
        $node->args[0]->value = $this->joinStringWithNode('p:', $node->args[0]->value);
        return $node;
    }
    private function joinStringWithNode(string $string, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($string . $expr->value);
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat(new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($string), $expr);
    }
}
