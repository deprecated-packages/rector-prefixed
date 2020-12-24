<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php55\NodeFactory;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\PhpParser\Parser;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper0a6b37af0871\PhpParser\Parser $parser)
    {
        $this->parser = $parser;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    public function createAnonymousFunctionFromString(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure
    {
        if (!$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
            // not supported yet
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        $phpCode = '<?php ' . $expr->value . ';';
        $contentNodes = (array) $this->parser->parse($phpCode);
        $anonymousFunction = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure();
        $firstNode = $contentNodes[0] ?? null;
        if (!$firstNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        $stmt = $firstNode->expr;
        $this->callableNodeTraverser->traverseNodesWithCallable($stmt, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) : Node {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
                return $node;
            }
            $match = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($node->value, self::DIM_FETCH_REGEX);
            if (!$match) {
                return $node;
            }
            $matchesVariable = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('matches');
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch($matchesVariable, new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber((int) $match['number']));
        });
        $anonymousFunction->stmts[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_($stmt);
        $anonymousFunction->params[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Param(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('matches'));
        return $anonymousFunction;
    }
}
