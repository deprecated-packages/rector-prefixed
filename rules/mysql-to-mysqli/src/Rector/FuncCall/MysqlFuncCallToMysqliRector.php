<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\MysqlToMysqli\Rector\FuncCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.phpclasses.org/blog/package/9199/post/3-Smoothly-Migrate-your-PHP-Code-using-the-Old-MySQL-extension-to-MySQLi.html
 *
 * @see \Rector\MysqlToMysqli\Tests\Rector\FuncCall\MysqlFuncCallToMysqliRector\MysqlFuncCallToMysqliRectorTest
 */
final class MysqlFuncCallToMysqliRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const MYSQLI_QUERY = 'mysqli_query';
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Converts more complex mysql functions to mysqli', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
mysql_drop_db($database);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
mysqli_query('DROP DATABASE ' . $database);
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
        if ($this->isName($node, 'mysql_create_db')) {
            return $this->processMysqlCreateDb($node);
        }
        if ($this->isName($node, 'mysql_drop_db')) {
            return $this->processMysqlDropDb($node);
        }
        if ($this->isName($node, 'mysql_list_dbs')) {
            $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name(self::MYSQLI_QUERY);
            $node->args[0] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg(new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_('SHOW DATABASES'));
        }
        if ($this->isName($node, 'mysql_list_fields')) {
            $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name(self::MYSQLI_QUERY);
            $node->args[0]->value = $this->joinStringWithNode('SHOW COLUMNS FROM', $node->args[1]->value);
            unset($node->args[1]);
        }
        if ($this->isName($node, 'mysql_list_tables')) {
            $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name(self::MYSQLI_QUERY);
            $node->args[0]->value = $this->joinStringWithNode('SHOW TABLES FROM', $node->args[0]->value);
        }
        return $node;
    }
    private function processMysqlCreateDb(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall
    {
        $funcCall->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name(self::MYSQLI_QUERY);
        $funcCall->args[0]->value = $this->joinStringWithNode('CREATE DATABASE', $funcCall->args[0]->value);
        return $funcCall;
    }
    private function processMysqlDropDb(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall
    {
        $funcCall->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name(self::MYSQLI_QUERY);
        $funcCall->args[0]->value = $this->joinStringWithNode('DROP DATABASE', $funcCall->args[0]->value);
        return $funcCall;
    }
    private function joinStringWithNode(string $string, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($string . ' ' . $expr->value);
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat(new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($string . ' '), $expr);
    }
}
