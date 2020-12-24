<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\Rector\Identical;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryMinus;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/nette/utils/blob/master/src/Utils/Strings.php
 * @see \Rector\Nette\Tests\Rector\Identical\EndsWithFunctionToNetteUtilsStringsRector\EndsWithFunctionToNetteUtilsStringsRectorTest
 */
final class EndsWithFunctionToNetteUtilsStringsRector extends \_PhpScopere8e811afab72\Rector\Nette\Rector\Identical\AbstractWithFunctionToNetteUtilsStringsRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use Nette\\Utils\\Strings::endsWith() over bare string-functions', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function end($needle)
    {
        $content = 'Hi, my name is Tom';

        $yes = substr($content, -strlen($needle)) === $needle;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function end($needle)
    {
        $content = 'Hi, my name is Tom';

        $yes = \Nette\Utils\Strings::endsWith($content, $needle);
    }
}
CODE_SAMPLE
)]);
    }
    public function getMethodName() : string
    {
        return 'endsWith';
    }
    public function matchContentAndNeedleOfSubstrOfVariableLength(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScopere8e811afab72\Rector\Nette\ValueObject\ContentExprAndNeedleExpr
    {
        if (!$this->isFuncCallName($node, 'substr')) {
            return null;
        }
        /** @var FuncCall $node */
        if (!$node->args[1]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryMinus) {
            return null;
        }
        /** @var UnaryMinus $unaryMinus */
        $unaryMinus = $node->args[1]->value;
        if (!$this->isFuncCallName($unaryMinus->expr, 'strlen')) {
            return null;
        }
        /** @var FuncCall $strlenFuncCall */
        $strlenFuncCall = $unaryMinus->expr;
        if ($this->areNodesEqual($strlenFuncCall->args[0]->value, $variable)) {
            return new \_PhpScopere8e811afab72\Rector\Nette\ValueObject\ContentExprAndNeedleExpr($node->args[0]->value, $strlenFuncCall->args[0]->value);
        }
        return null;
    }
}
