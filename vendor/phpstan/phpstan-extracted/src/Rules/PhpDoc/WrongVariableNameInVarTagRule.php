<?php

declare (strict_types=1);
namespace PHPStan\Rules\PhpDoc;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\FileTypeMapper;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node>
 */
class WrongVariableNameInVarTagRule implements \PHPStan\Rules\Rule
{
    /** @var FileTypeMapper */
    private $fileTypeMapper;
    public function __construct(\PHPStan\Type\FileTypeMapper $fileTypeMapper)
    {
        $this->fileTypeMapper = $fileTypeMapper;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \PhpParser\Node\Stmt\Foreach_ && !$node instanceof \PhpParser\Node\Expr\Assign && !$node instanceof \PhpParser\Node\Expr\AssignRef && !$node instanceof \PhpParser\Node\Stmt\Static_ && !$node instanceof \PhpParser\Node\Stmt\Echo_ && !$node instanceof \PhpParser\Node\Stmt\Return_ && !$node instanceof \PhpParser\Node\Stmt\Expression && !$node instanceof \PhpParser\Node\Stmt\Throw_ && !$node instanceof \PhpParser\Node\Stmt\If_ && !$node instanceof \PhpParser\Node\Stmt\While_ && !$node instanceof \PhpParser\Node\Stmt\Switch_ && !$node instanceof \PhpParser\Node\Stmt\Nop) {
            return [];
        }
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        $function = $scope->getFunction();
        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $scope->isInClass() ? $scope->getClassReflection()->getName() : null, $scope->isInTrait() ? $scope->getTraitReflection()->getName() : null, $function !== null ? $function->getName() : null, $docComment->getText());
        $varTags = $resolvedPhpDoc->getVarTags();
        if (\count($varTags) === 0) {
            return [];
        }
        if ($node instanceof \PhpParser\Node\Expr\Assign || $node instanceof \PhpParser\Node\Expr\AssignRef) {
            return $this->processAssign($scope, $node->var, $varTags);
        }
        if ($node instanceof \PhpParser\Node\Stmt\Foreach_) {
            return $this->processForeach($node->keyVar, $node->valueVar, $varTags);
        }
        if ($node instanceof \PhpParser\Node\Stmt\Static_) {
            return $this->processStatic($node->vars, $varTags);
        }
        if ($node instanceof \PhpParser\Node\Stmt\Expression) {
            return $this->processExpression($scope, $node->expr, $varTags);
        }
        if ($node instanceof \PhpParser\Node\Stmt\Throw_ || $node instanceof \PhpParser\Node\Stmt\Return_) {
            return $this->processStmt($scope, $varTags, $node->expr);
        }
        return $this->processStmt($scope, $varTags, null);
    }
    /**
     * @param \PHPStan\Analyser\Scope $scope
     * @param \PhpParser\Node\Expr $var
     * @param \PHPStan\PhpDoc\Tag\VarTag[] $varTags
     * @return \PHPStan\Rules\RuleError[]
     */
    private function processAssign(\PHPStan\Analyser\Scope $scope, \PhpParser\Node\Expr $var, array $varTags) : array
    {
        if ($var instanceof \PhpParser\Node\Expr\Variable && \is_string($var->name)) {
            if (\count($varTags) === 1) {
                $key = \key($varTags);
                if (\is_int($key)) {
                    return [];
                }
                if ($key !== $var->name) {
                    if (!$scope->hasVariableType($key)->no()) {
                        return [];
                    }
                    return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s in PHPDoc tag @var does not match assigned variable $%s.', $key, $var->name))->build()];
                }
                return [];
            }
            return [\PHPStan\Rules\RuleErrorBuilder::message('Multiple PHPDoc @var tags above single variable assignment are not supported.')->build()];
        }
        return [];
    }
    /**
     * @param \PhpParser\Node\Expr|null $keyVar
     * @param \PhpParser\Node\Expr $valueVar
     * @param \PHPStan\PhpDoc\Tag\VarTag[] $varTags
     * @return \PHPStan\Rules\RuleError[]
     */
    private function processForeach(?\PhpParser\Node\Expr $keyVar, \PhpParser\Node\Expr $valueVar, array $varTags) : array
    {
        $variableNames = [];
        if ($keyVar instanceof \PhpParser\Node\Expr\Variable && \is_string($keyVar->name)) {
            $variableNames[$keyVar->name] = \true;
        }
        if ($valueVar instanceof \PhpParser\Node\Expr\Variable && \is_string($valueVar->name)) {
            $variableNames[$valueVar->name] = \true;
        }
        if ($valueVar instanceof \PhpParser\Node\Expr\Array_ || $valueVar instanceof \PhpParser\Node\Expr\List_) {
            $variableNames = $this->getVariablesFromList($variableNames, $valueVar->items);
        }
        $errors = [];
        foreach (\array_keys($varTags) as $name) {
            if (\is_int($name)) {
                $errors[] = \PHPStan\Rules\RuleErrorBuilder::message('PHPDoc tag @var above foreach loop does not specify variable name.')->build();
                continue;
            }
            if (isset($variableNames[$name])) {
                continue;
            }
            $errors[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s in PHPDoc tag @var does not match any variable in the foreach loop: %s', $name, \implode(', ', \array_map(static function (string $name) : string {
                return \sprintf('$%s', $name);
            }, \array_keys($variableNames)))))->build();
        }
        return $errors;
    }
    /**
     * @param array<string, true> $variableNames
     * @param (\PhpParser\Node\Expr\ArrayItem|null)[] $items
     * @return array<string, true>
     */
    private function getVariablesFromList(array $variableNames, array $items) : array
    {
        foreach ($items as $item) {
            if ($item === null) {
                continue;
            }
            $value = $item->value;
            if ($value instanceof \PhpParser\Node\Expr\Variable && \is_string($value->name)) {
                $variableNames[$value->name] = \true;
                continue;
            }
            if (!$value instanceof \PhpParser\Node\Expr\Array_ && !$value instanceof \PhpParser\Node\Expr\List_) {
                continue;
            }
            $variableNames = $this->getVariablesFromList($variableNames, $value->items);
        }
        return $variableNames;
    }
    /**
     * @param \PhpParser\Node\Stmt\StaticVar[] $vars
     * @param \PHPStan\PhpDoc\Tag\VarTag[] $varTags
     * @return \PHPStan\Rules\RuleError[]
     */
    private function processStatic(array $vars, array $varTags) : array
    {
        $variableNames = [];
        foreach ($vars as $var) {
            if (!\is_string($var->var->name)) {
                continue;
            }
            $variableNames[$var->var->name] = \true;
        }
        $errors = [];
        foreach (\array_keys($varTags) as $name) {
            if (\is_int($name)) {
                if (\count($vars) === 1) {
                    continue;
                }
                $errors[] = \PHPStan\Rules\RuleErrorBuilder::message('PHPDoc tag @var above multiple static variables does not specify variable name.')->build();
                continue;
            }
            if (isset($variableNames[$name])) {
                continue;
            }
            $errors[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s in PHPDoc tag @var does not match any static variable: %s', $name, \implode(', ', \array_map(static function (string $name) : string {
                return \sprintf('$%s', $name);
            }, \array_keys($variableNames)))))->build();
        }
        return $errors;
    }
    /**
     * @param \PHPStan\Analyser\Scope $scope
     * @param \PhpParser\Node\Expr $expr
     * @param \PHPStan\PhpDoc\Tag\VarTag[] $varTags
     * @return \PHPStan\Rules\RuleError[]
     */
    private function processExpression(\PHPStan\Analyser\Scope $scope, \PhpParser\Node\Expr $expr, array $varTags) : array
    {
        if ($expr instanceof \PhpParser\Node\Expr\Assign || $expr instanceof \PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        return $this->processStmt($scope, $varTags, null);
    }
    /**
     * @param \PHPStan\Analyser\Scope $scope
     * @param \PHPStan\PhpDoc\Tag\VarTag[] $varTags
     * @param Expr|null $defaultExpr
     * @return \PHPStan\Rules\RuleError[]
     */
    private function processStmt(\PHPStan\Analyser\Scope $scope, array $varTags, ?\PhpParser\Node\Expr $defaultExpr) : array
    {
        $errors = [];
        $variableLessVarTags = [];
        foreach ($varTags as $name => $varTag) {
            if (\is_int($name)) {
                $variableLessVarTags[] = $varTag;
                continue;
            }
            if (!$scope->hasVariableType($name)->no()) {
                continue;
            }
            $errors[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s in PHPDoc tag @var does not exist.', $name))->build();
        }
        if (\count($variableLessVarTags) !== 1 || $defaultExpr === null) {
            if (\count($variableLessVarTags) > 0) {
                $errors[] = \PHPStan\Rules\RuleErrorBuilder::message('PHPDoc tag @var does not specify variable name.')->build();
            }
        }
        return $errors;
    }
}
