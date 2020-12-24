<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Parser;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
class FunctionCallStatementFinder
{
    /**
     * @param string[] $functionNames
     * @param mixed $statements
     * @return \PhpParser\Node|null
     */
    public function findFunctionCallInStatements(array $functionNames, $statements) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($statements as $statement) {
            if (\is_array($statement)) {
                $result = $this->findFunctionCallInStatements($functionNames, $statement);
                if ($result !== null) {
                    return $result;
                }
            }
            if (!$statement instanceof \_PhpScopere8e811afab72\PhpParser\Node) {
                continue;
            }
            if ($statement instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall && $statement->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
                if (\in_array((string) $statement->name, $functionNames, \true)) {
                    return $statement;
                }
            }
            $result = $this->findFunctionCallInStatements($functionNames, $statement);
            if ($result !== null) {
                return $result;
            }
        }
        return null;
    }
}
