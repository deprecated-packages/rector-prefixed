<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\Rector\FuncCall;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
/**
 * @see https://www.tomasvotruba.cz/blog/2019/02/07/what-i-learned-by-using-thecodingmachine-safe/#is-there-a-better-way
 *
 * @see \Rector\Nette\Tests\Rector\FuncCall\PregMatchFunctionToNetteUtilsStringsRector\PregMatchFunctionToNetteUtilsStringsRectorTest
 */
abstract class AbstractPregToNetteUtilsStringsRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @param array<string, string> $functionRenameMap
     */
    protected function matchFuncCallRenameToMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall, array $functionRenameMap) : ?string
    {
        $oldFunctionNames = \array_keys($functionRenameMap);
        if (!$this->isNames($funcCall, $oldFunctionNames)) {
            return null;
        }
        $currentFunctionName = $this->getName($funcCall);
        return $functionRenameMap[$currentFunctionName];
    }
}
