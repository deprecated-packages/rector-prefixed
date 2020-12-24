<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php55\NodeFactory;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\PhpParser\Parser;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
final class AnonymousFunctionNodeFactory
{
    /**
     * @var string
     * @see https://regex101.com/r/jkLLlM/2
     */
    private const DIM_FETCH_REGEX = '#(\\$|\\\\|\\x0)(?<number>\\d+)#';
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\PhpParser\Parser $parser)
    {
        $this->parser = $parser;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    public function createAnonymousFunctionFromString(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure
    {
        if (!$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            // not supported yet
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $phpCode = '<?php ' . $expr->value . ';';
        $contentNodes = (array) $this->parser->parse($phpCode);
        $anonymousFunction = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure();
        $firstNode = $contentNodes[0] ?? null;
        if (!$firstNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        $stmt = $firstNode->expr;
        $this->callableNodeTraverser->traverseNodesWithCallable($stmt, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : Node {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
                return $node;
            }
            $match = \_PhpScopere8e811afab72\Nette\Utils\Strings::match($node->value, self::DIM_FETCH_REGEX);
            if (!$match) {
                return $node;
            }
            $matchesVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('matches');
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch($matchesVariable, new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber((int) $match['number']));
        });
        $anonymousFunction->stmts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($stmt);
        $anonymousFunction->params[] = new \_PhpScopere8e811afab72\PhpParser\Node\Param(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('matches'));
        return $anonymousFunction;
    }
}
