<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\AlreadyAssignDetector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher;
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
    public function autowireAbstractAssignDetector(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher $propertyAssignMatcher, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser) : void
    {
        $this->propertyAssignMatcher = $propertyAssignMatcher;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    protected function matchAssignExprToPropertyName(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $propertyName) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return null;
        }
        return $this->propertyAssignMatcher->matchPropertyAssignExpr($node, $propertyName);
    }
}
