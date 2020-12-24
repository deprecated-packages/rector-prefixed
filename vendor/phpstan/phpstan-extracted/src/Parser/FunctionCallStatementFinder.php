<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Parser;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
class FunctionCallStatementFinder
{
    /**
     * @param string[] $functionNames
     * @param mixed $statements
     * @return \PhpParser\Node|null
     */
    public function findFunctionCallInStatements(array $functionNames, $statements) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        foreach ($statements as $statement) {
            if (\is_array($statement)) {
                $result = $this->findFunctionCallInStatements($functionNames, $statement);
                if ($result !== null) {
                    return $result;
                }
            }
            if (!$statement instanceof \_PhpScoper0a6b37af0871\PhpParser\Node) {
                continue;
            }
            if ($statement instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall && $statement->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
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
