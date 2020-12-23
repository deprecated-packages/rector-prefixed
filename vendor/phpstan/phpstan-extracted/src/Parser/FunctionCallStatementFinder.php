<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Parser;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
class FunctionCallStatementFinder
{
    /**
     * @param string[] $functionNames
     * @param mixed $statements
     * @return \PhpParser\Node|null
     */
    public function findFunctionCallInStatements(array $functionNames, $statements) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        foreach ($statements as $statement) {
            if (\is_array($statement)) {
                $result = $this->findFunctionCallInStatements($functionNames, $statement);
                if ($result !== null) {
                    return $result;
                }
            }
            if (!$statement instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node) {
                continue;
            }
            if ($statement instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall && $statement->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
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
