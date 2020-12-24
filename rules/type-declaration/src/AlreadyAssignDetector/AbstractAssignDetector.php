<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\AlreadyAssignDetector;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher;
abstract class AbstractAssignDetector
{
    /**
     * @var CallableNodeTraverser
     */
    protected $callableNodeTraverser;
    /**
     * @var PropertyAssignMatcher
     */
    private $propertyAssignMatcher;
    /**
     * @required
     */
    public function autowireAbstractAssignDetector(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher $propertyAssignMatcher, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser) : void
    {
        $this->propertyAssignMatcher = $propertyAssignMatcher;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    protected function matchAssignExprToPropertyName(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $propertyName) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
            return null;
        }
        return $this->propertyAssignMatcher->matchPropertyAssignExpr($node, $propertyName);
    }
}
