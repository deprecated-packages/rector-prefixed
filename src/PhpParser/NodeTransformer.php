<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Yield_;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\SprintfStringAndArgs;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class NodeTransformer
{
    /**
     * @var string
     * @see https://regex101.com/r/XFc3qA/1
     */
    private const PERCENT_TEXT_REGEX = '#^%\\w$#';
    /**
     * From:
     * - sprintf("Hi %s", $name);
     *
     * to:
     * - ["Hi %s", $name]
     */
    public function transformSprintfToArray(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $sprintfFuncCall) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_
    {
        $sprintfStringAndArgs = $this->splitMessageAndArgs($sprintfFuncCall);
        if ($sprintfStringAndArgs === null) {
            return null;
        }
        $arrayItems = $sprintfStringAndArgs->getArrayItems();
        $stringValue = $sprintfStringAndArgs->getStringValue();
        $messageParts = $this->splitBySpace($stringValue);
        $arrayMessageParts = [];
        foreach ($messageParts as $messagePart) {
            if (\_PhpScopere8e811afab72\Nette\Utils\Strings::match($messagePart, self::PERCENT_TEXT_REGEX)) {
                /** @var Expr $messagePartNode */
                $messagePartNode = \array_shift($arrayItems);
            } else {
                $messagePartNode = new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($messagePart);
            }
            $arrayMessageParts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem($messagePartNode);
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_($arrayMessageParts);
    }
    /**
     * @param Yield_[]|Expression[] $yieldNodes
     */
    public function transformYieldsToArray(array $yieldNodes) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_
    {
        $arrayItems = [];
        foreach ($yieldNodes as $yieldNode) {
            if ($yieldNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
                $yieldNode = $yieldNode->expr;
            }
            if (!$yieldNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Yield_) {
                continue;
            }
            if ($yieldNode->value === null) {
                continue;
            }
            $arrayItems[] = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem($yieldNode->value, $yieldNode->key);
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_($arrayItems);
    }
    /**
     * @return Expression[]
     */
    public function transformArrayToYields(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_ $array) : array
    {
        $yieldNodes = [];
        foreach ($array->items as $arrayItem) {
            if ($arrayItem === null) {
                continue;
            }
            $expressionNode = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Yield_($arrayItem->value, $arrayItem->key));
            $arrayItemComments = $arrayItem->getComments();
            if ($arrayItemComments !== []) {
                $expressionNode->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $arrayItemComments);
            }
            $yieldNodes[] = $expressionNode;
        }
        return $yieldNodes;
    }
    public function transformConcatToStringArray(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat $concat) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_
    {
        $arrayItems = $this->transformConcatToItems($concat);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_($arrayItems);
    }
    private function splitMessageAndArgs(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $sprintfFuncCall) : ?\_PhpScopere8e811afab72\Rector\Core\ValueObject\SprintfStringAndArgs
    {
        $stringArgument = null;
        $arrayItems = [];
        foreach ($sprintfFuncCall->args as $i => $arg) {
            if ($i === 0) {
                $stringArgument = $arg->value;
            } else {
                $arrayItems[] = $arg->value;
            }
        }
        if (!$stringArgument instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return null;
        }
        if ($arrayItems === []) {
            return null;
        }
        return new \_PhpScopere8e811afab72\Rector\Core\ValueObject\SprintfStringAndArgs($stringArgument, $arrayItems);
    }
    /**
     * @return string[]
     */
    private function splitBySpace(string $value) : array
    {
        $value = \str_getcsv($value, ' ');
        return \array_filter($value);
    }
    /**
     * @return mixed[]
     */
    private function transformConcatToItems(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat $concat) : array
    {
        $arrayItems = $this->transformConcatItemToArrayItems($concat->left);
        return \array_merge($arrayItems, $this->transformConcatItemToArrayItems($concat->right));
    }
    /**
     * @return mixed[]|Expr[]|String_[]
     */
    private function transformConcatItemToArrayItems(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : array
    {
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat) {
            return $this->transformConcatToItems($expr);
        }
        if (!$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return [$expr];
        }
        $arrayItems = [];
        $parts = $this->splitBySpace($expr->value);
        foreach ($parts as $part) {
            if (\trim($part) !== '') {
                $arrayItems[] = new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($part);
            }
        }
        return $arrayItems;
    }
}
