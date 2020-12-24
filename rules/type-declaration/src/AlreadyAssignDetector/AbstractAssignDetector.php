<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\AlreadyAssignDetector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher;
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
    public function autowireAbstractAssignDetector(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher $propertyAssignMatcher, \_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser) : void
    {
        $this->propertyAssignMatcher = $propertyAssignMatcher;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    protected function matchAssignExprToPropertyName(\_PhpScopere8e811afab72\PhpParser\Node $node, string $propertyName) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return null;
        }
        return $this->propertyAssignMatcher->matchPropertyAssignExpr($node, $propertyName);
    }
}
