<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php55\NodeFactory;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PhpParser\Parser;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoperb75b35f52b74\PhpParser\Parser $parser)
    {
        $this->parser = $parser;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    public function createAnonymousFunctionFromString(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure
    {
        if (!$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            // not supported yet
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $phpCode = '<?php ' . $expr->value . ';';
        $contentNodes = (array) $this->parser->parse($phpCode);
        $anonymousFunction = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure();
        $firstNode = $contentNodes[0] ?? null;
        if (!$firstNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        $stmt = $firstNode->expr;
        $this->callableNodeTraverser->traverseNodesWithCallable($stmt, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : Node {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
                return $node;
            }
            $match = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($node->value, self::DIM_FETCH_REGEX);
            if (!$match) {
                return $node;
            }
            $matchesVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('matches');
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch($matchesVariable, new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber((int) $match['number']));
        });
        $anonymousFunction->stmts[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_($stmt);
        $anonymousFunction->params[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Param(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('matches'));
        return $anonymousFunction;
    }
}
