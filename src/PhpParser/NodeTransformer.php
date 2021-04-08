<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser;

use RectorPrefix20210408\Nette\Utils\Strings;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Yield_;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\ValueObject\SprintfStringAndArgs;
use Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function transformSprintfToArray(\PhpParser\Node\Expr\FuncCall $sprintfFuncCall) : ?\PhpParser\Node\Expr\Array_
    {
        $sprintfStringAndArgs = $this->splitMessageAndArgs($sprintfFuncCall);
        if (!$sprintfStringAndArgs instanceof \Rector\Core\ValueObject\SprintfStringAndArgs) {
            return null;
        }
        $arrayItems = $sprintfStringAndArgs->getArrayItems();
        $stringValue = $sprintfStringAndArgs->getStringValue();
        $messageParts = $this->splitBySpace($stringValue);
        $arrayMessageParts = [];
        foreach ($messageParts as $messagePart) {
            if (\RectorPrefix20210408\Nette\Utils\Strings::match($messagePart, self::PERCENT_TEXT_REGEX)) {
                /** @var Expr $messagePartNode */
                $messagePartNode = \array_shift($arrayItems);
            } else {
                $messagePartNode = new \PhpParser\Node\Scalar\String_($messagePart);
            }
            $arrayMessageParts[] = new \PhpParser\Node\Expr\ArrayItem($messagePartNode);
        }
        return new \PhpParser\Node\Expr\Array_($arrayMessageParts);
    }
    /**
     * @param Yield_[]|Expression[] $yieldNodes
     */
    public function transformYieldsToArray(array $yieldNodes) : \PhpParser\Node\Expr\Array_
    {
        $arrayItems = [];
        foreach ($yieldNodes as $yieldNode) {
            if ($yieldNode instanceof \PhpParser\Node\Stmt\Expression) {
                $yieldNode = $yieldNode->expr;
            }
            if (!$yieldNode instanceof \PhpParser\Node\Expr\Yield_) {
                continue;
            }
            if ($yieldNode->value === null) {
                continue;
            }
            $arrayItems[] = new \PhpParser\Node\Expr\ArrayItem($yieldNode->value, $yieldNode->key);
        }
        return new \PhpParser\Node\Expr\Array_($arrayItems);
    }
    /**
     * @return Expression[]
     */
    public function transformArrayToYields(\PhpParser\Node\Expr\Array_ $array) : array
    {
        $yieldNodes = [];
        foreach ($array->items as $arrayItem) {
            if ($arrayItem === null) {
                continue;
            }
            $expressionNode = new \PhpParser\Node\Stmt\Expression(new \PhpParser\Node\Expr\Yield_($arrayItem->value, $arrayItem->key));
            $arrayItemComments = $arrayItem->getComments();
            if ($arrayItemComments !== []) {
                $expressionNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $arrayItemComments);
            }
            $yieldNodes[] = $expressionNode;
        }
        return $yieldNodes;
    }
    public function transformConcatToStringArray(\PhpParser\Node\Expr\BinaryOp\Concat $concat) : \PhpParser\Node\Expr\Array_
    {
        $arrayItems = $this->transformConcatToItems($concat);
        return new \PhpParser\Node\Expr\Array_($arrayItems);
    }
    private function splitMessageAndArgs(\PhpParser\Node\Expr\FuncCall $sprintfFuncCall) : ?\Rector\Core\ValueObject\SprintfStringAndArgs
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
        if (!$stringArgument instanceof \PhpParser\Node\Scalar\String_) {
            return null;
        }
        if ($arrayItems === []) {
            return null;
        }
        return new \Rector\Core\ValueObject\SprintfStringAndArgs($stringArgument, $arrayItems);
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
    private function transformConcatToItems(\PhpParser\Node\Expr\BinaryOp\Concat $concat) : array
    {
        $arrayItems = $this->transformConcatItemToArrayItems($concat->left);
        return \array_merge($arrayItems, $this->transformConcatItemToArrayItems($concat->right));
    }
    /**
     * @return mixed[]|Expr[]|String_[]
     */
    private function transformConcatItemToArrayItems(\PhpParser\Node\Expr $expr) : array
    {
        if ($expr instanceof \PhpParser\Node\Expr\BinaryOp\Concat) {
            return $this->transformConcatToItems($expr);
        }
        if (!$expr instanceof \PhpParser\Node\Scalar\String_) {
            return [$expr];
        }
        $arrayItems = [];
        $parts = $this->splitBySpace($expr->value);
        foreach ($parts as $part) {
            if (\trim($part) !== '') {
                $arrayItems[] = new \PhpParser\Node\Scalar\String_($part);
            }
        }
        return $arrayItems;
    }
}
