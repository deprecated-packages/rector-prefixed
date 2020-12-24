<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\MysqlToMysqli\Rector\Assign;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.phpclasses.org/blog/package/9199/post/3-Smoothly-Migrate-your-PHP-Code-using-the-Old-MySQL-extension-to-MySQLi.html
 * @see \Rector\MysqlToMysqli\Tests\Rector\Assign\MysqlAssignToMysqliRector\MysqlAssignToMysqliRectorTest
 */
final class MysqlAssignToMysqliRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var array<string, string>
     */
    private const FIELD_TO_FIELD_DIRECT = ['mysql_field_len' => 'length', 'mysql_field_name' => 'name', 'mysql_field_table' => 'table'];
    /**
     * @var string
     */
    private const MYSQLI_DATA_SEEK = 'mysqli_data_seek';
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Converts more complex mysql functions to mysqli', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$data = mysql_db_name($result, $row);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
mysqli_data_seek($result, $row);
$fetch = mysql_fetch_row($result);
$data = $fetch[0];
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall) {
            return null;
        }
        /** @var FuncCall $funcCallNode */
        $funcCallNode = $node->expr;
        if ($this->isName($funcCallNode, 'mysql_tablename')) {
            return $this->processMysqlTableName($node, $funcCallNode);
        }
        if ($this->isName($funcCallNode, 'mysql_db_name')) {
            return $this->processMysqlDbName($node, $funcCallNode);
        }
        if ($this->isName($funcCallNode, 'mysql_db_query')) {
            return $this->processMysqliSelectDb($node, $funcCallNode);
        }
        if ($this->isName($funcCallNode, 'mysql_fetch_field')) {
            return $this->processMysqlFetchField($node, $funcCallNode);
        }
        if ($this->isName($funcCallNode, 'mysql_result')) {
            return $this->processMysqlResult($node, $funcCallNode);
        }
        return $this->processFieldToFieldDirect($node, $funcCallNode);
    }
    private function processMysqlTableName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign $assign, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall
    {
        $funcCall->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name(self::MYSQLI_DATA_SEEK);
        $newFuncCall = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('mysql_fetch_array'), [$funcCall->args[0]]);
        $newAssignNode = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign($assign->var, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch($newFuncCall, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber(0)));
        $this->addNodeAfterNode($newAssignNode, $assign);
        return $funcCall;
    }
    private function processMysqlDbName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign $assign, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall
    {
        $funcCall->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name(self::MYSQLI_DATA_SEEK);
        $mysqlFetchRowFuncCall = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('mysqli_fetch_row'), [$funcCall->args[0]]);
        $fetchVariable = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('fetch');
        $newAssignNode = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign($fetchVariable, $mysqlFetchRowFuncCall);
        $this->addNodeAfterNode($newAssignNode, $assign);
        $newAssignNode = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign($assign->var, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch($fetchVariable, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber(0)));
        $this->addNodeAfterNode($newAssignNode, $assign);
        return $funcCall;
    }
    private function processMysqliSelectDb(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign $assign, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall
    {
        $funcCall->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('mysqli_select_db');
        $newAssignNode = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign($assign->var, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('mysqli_query'), [$funcCall->args[1]]));
        $this->addNodeAfterNode($newAssignNode, $assign);
        unset($funcCall->args[1]);
        return $funcCall;
    }
    private function processMysqlFetchField(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign $assign, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign
    {
        if (isset($funcCall->args[1])) {
            $funcCall->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('mysqli_fetch_field_direct');
        } else {
            $funcCall->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('mysqli_fetch_field');
        }
        return $assign;
    }
    private function processMysqlResult(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign $assign, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall
    {
        $fetchField = null;
        if (isset($funcCall->args[2])) {
            $fetchField = $funcCall->args[2]->value;
            unset($funcCall->args[2]);
        }
        $funcCall->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name(self::MYSQLI_DATA_SEEK);
        $mysqlFetchArrayFuncCall = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('mysqli_fetch_array'), [$funcCall->args[0]]);
        $fetchVariable = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('fetch');
        $newAssignNode = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign($fetchVariable, $mysqlFetchArrayFuncCall);
        $this->addNodeAfterNode($newAssignNode, $assign);
        $newAssignNode = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign($assign->var, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch($fetchVariable, $fetchField ?? new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber(0)));
        $this->addNodeAfterNode($newAssignNode, $assign);
        return $funcCall;
    }
    private function processFieldToFieldDirect(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign $assign, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign
    {
        foreach (self::FIELD_TO_FIELD_DIRECT as $funcName => $property) {
            if ($this->isName($funcCall, $funcName)) {
                $parentNode = $funcCall->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
                if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch || $parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticPropertyFetch) {
                    continue;
                }
                $funcCall->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('mysqli_fetch_field_direct');
                $assign->expr = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch($funcCall, $property);
                return $assign;
            }
        }
        return null;
    }
}
