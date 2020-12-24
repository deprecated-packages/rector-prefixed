<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\Rector\Identical;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/nette/utils/blob/master/src/Utils/Strings.php
 *
 * @see \Rector\Nette\Tests\Rector\Identical\StartsWithFunctionToNetteUtilsStringsRector\StartsWithFunctionToNetteUtilsStringsRectorTest
 */
final class StartsWithFunctionToNetteUtilsStringsRector extends \_PhpScoper0a6b37af0871\Rector\Nette\Rector\Identical\AbstractWithFunctionToNetteUtilsStringsRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use Nette\\Utils\\Strings::startsWith() over bare string-functions', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function start($needle)
    {
        $content = 'Hi, my name is Tom';

        $yes = substr($content, 0, strlen($needle)) === $needle;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function start($needle)
    {
        $content = 'Hi, my name is Tom';

        $yes = \Nette\Utils\Strings::startsWith($content, $needle);
    }
}
CODE_SAMPLE
)]);
    }
    public function getMethodName() : string
    {
        return 'startsWith';
    }
    public function matchContentAndNeedleOfSubstrOfVariableLength(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoper0a6b37af0871\Rector\Nette\ValueObject\ContentExprAndNeedleExpr
    {
        if (!$this->isFuncCallName($node, 'substr')) {
            return null;
        }
        /** @var FuncCall $node */
        if (!$this->isValue($node->args[1]->value, 0)) {
            return null;
        }
        if (!isset($node->args[2])) {
            return null;
        }
        if (!$node->args[2]->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            return null;
        }
        if (!$this->isName($node->args[2]->value, 'strlen')) {
            return null;
        }
        /** @var FuncCall $strlenFuncCall */
        $strlenFuncCall = $node->args[2]->value;
        if ($this->areNodesEqual($strlenFuncCall->args[0]->value, $variable)) {
            return new \_PhpScoper0a6b37af0871\Rector\Nette\ValueObject\ContentExprAndNeedleExpr($node->args[0]->value, $strlenFuncCall->args[0]->value);
        }
        return null;
    }
}
