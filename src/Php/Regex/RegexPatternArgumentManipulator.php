<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Php\Regex;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class RegexPatternArgumentManipulator
{
    /**
     * @var int[]
     */
    private const FUNCTIONS_WITH_PATTERNS_TO_ARGUMENT_POSITION = ['preg_match' => 0, 'preg_replace_callback_array' => 0, 'preg_replace_callback' => 0, 'preg_replace' => 0, 'preg_match_all' => 0, 'preg_split' => 0, 'preg_grep' => 0];
    /**
     * @var array<string, array<string, int>>
     */
    private const STATIC_METHODS_WITH_PATTERNS_TO_ARGUMENT_POSITION = [\_PhpScopere8e811afab72\Nette\Utils\Strings::class => ['match' => 1, 'matchAll' => 1, 'replace' => 1, 'split' => 1]];
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var ParsedNodeCollector
     */
    private $parsedNodeCollector;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @return String_[]
     */
    public function matchCallArgumentWithRegexPattern(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : array
    {
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            return $this->processFuncCall($expr);
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return $this->processStaticCall($expr);
        }
        return [];
    }
    /**
     * @return String_[]
     */
    private function processFuncCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : array
    {
        foreach (self::FUNCTIONS_WITH_PATTERNS_TO_ARGUMENT_POSITION as $functionName => $argumentPosition) {
            if (!$this->nodeNameResolver->isName($funcCall, $functionName)) {
                continue;
            }
            if (!isset($funcCall->args[$argumentPosition])) {
                return [];
            }
            return $this->resolveArgumentValues($funcCall->args[$argumentPosition]->value);
        }
        return [];
    }
    /**
     * @return String_[]
     */
    private function processStaticCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall $staticCall) : array
    {
        foreach (self::STATIC_METHODS_WITH_PATTERNS_TO_ARGUMENT_POSITION as $type => $methodNamesToArgumentPosition) {
            if (!$this->nodeTypeResolver->isObjectType($staticCall->class, $type)) {
                continue;
            }
            foreach ($methodNamesToArgumentPosition as $methodName => $argumentPosition) {
                if (!$this->nodeNameResolver->isName($staticCall->name, $methodName)) {
                    continue;
                }
                if (!isset($staticCall->args[$argumentPosition])) {
                    return [];
                }
                return $this->resolveArgumentValues($staticCall->args[$argumentPosition]->value);
            }
        }
        return [];
    }
    /**
     * @return String_[]
     */
    private function resolveArgumentValues(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : array
    {
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return [$expr];
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            $strings = [];
            $assignNodes = $this->findAssignerForVariable($expr);
            foreach ($assignNodes as $assignNode) {
                if ($assignNode->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
                    $strings[] = $assignNode->expr;
                }
            }
            return $strings;
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch) {
            return $this->resolveClassConstFetchValue($expr);
        }
        return [];
    }
    /**
     * @return Assign[]
     */
    private function findAssignerForVariable(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : array
    {
        $classMethod = $variable->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($classMethod === null) {
            return [];
        }
        return $this->betterNodeFinder->find([$classMethod], function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($variable) : ?Assign {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->betterStandardPrinter->areNodesEqual($node->var, $variable)) {
                return null;
            }
            return $node;
        });
    }
    /**
     * @return String_[]
     */
    private function resolveClassConstFetchValue(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch $classConstFetch) : array
    {
        $classConstNode = $this->parsedNodeCollector->findClassConstByClassConstFetch($classConstFetch);
        if ($classConstNode === null) {
            return [];
        }
        if ($classConstNode->consts[0]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return [$classConstNode->consts[0]->value];
        }
        return [];
    }
}
