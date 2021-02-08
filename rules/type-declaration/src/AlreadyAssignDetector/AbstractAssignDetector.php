<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\AlreadyAssignDetector;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use Rector\TypeDeclaration\Matcher\PropertyAssignMatcher;
use RectorPrefix20210208\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
abstract class AbstractAssignDetector
{
    /**
     * @var SimpleCallableNodeTraverser
     */
    protected $simpleCallableNodeTraverser;
    /**
     * @var PropertyAssignMatcher
     */
    private $propertyAssignMatcher;
    /**
     * @required
     */
    public function autowireAbstractAssignDetector(\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher $propertyAssignMatcher, \RectorPrefix20210208\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser) : void
    {
        $this->propertyAssignMatcher = $propertyAssignMatcher;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
    }
    protected function matchAssignExprToPropertyName(\PhpParser\Node $node, string $propertyName) : ?\PhpParser\Node\Expr
    {
        if (!$node instanceof \PhpParser\Node\Expr\Assign) {
            return null;
        }
        return $this->propertyAssignMatcher->matchPropertyAssignExpr($node, $propertyName);
    }
}
