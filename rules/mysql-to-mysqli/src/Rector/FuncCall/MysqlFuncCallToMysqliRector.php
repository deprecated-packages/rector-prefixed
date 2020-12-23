<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\MysqlToMysqli\Rector\FuncCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.phpclasses.org/blog/package/9199/post/3-Smoothly-Migrate-your-PHP-Code-using-the-Old-MySQL-extension-to-MySQLi.html
 *
 * @see \Rector\MysqlToMysqli\Tests\Rector\FuncCall\MysqlFuncCallToMysqliRector\MysqlFuncCallToMysqliRectorTest
 */
final class MysqlFuncCallToMysqliRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const MYSQLI_QUERY = 'mysqli_query';
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Converts more complex mysql functions to mysqli', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($this->isName($node, 'mysql_create_db')) {
            return $this->processMysqlCreateDb($node);
        }
        if ($this->isName($node, 'mysql_drop_db')) {
            return $this->processMysqlDropDb($node);
        }
        if ($this->isName($node, 'mysql_list_dbs')) {
            $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name(self::MYSQLI_QUERY);
            $node->args[0] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_('SHOW DATABASES'));
        }
        if ($this->isName($node, 'mysql_list_fields')) {
            $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name(self::MYSQLI_QUERY);
            $node->args[0]->value = $this->joinStringWithNode('SHOW COLUMNS FROM', $node->args[1]->value);
            unset($node->args[1]);
        }
        if ($this->isName($node, 'mysql_list_tables')) {
            $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name(self::MYSQLI_QUERY);
            $node->args[0]->value = $this->joinStringWithNode('SHOW TABLES FROM', $node->args[0]->value);
        }
        return $node;
    }
    private function processMysqlCreateDb(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall
    {
        $funcCall->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name(self::MYSQLI_QUERY);
        $funcCall->args[0]->value = $this->joinStringWithNode('CREATE DATABASE', $funcCall->args[0]->value);
        return $funcCall;
    }
    private function processMysqlDropDb(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall
    {
        $funcCall->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name(self::MYSQLI_QUERY);
        $funcCall->args[0]->value = $this->joinStringWithNode('DROP DATABASE', $funcCall->args[0]->value);
        return $funcCall;
    }
    private function joinStringWithNode(string $string, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($string . ' ' . $expr->value);
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($string . ' '), $expr);
    }
}
