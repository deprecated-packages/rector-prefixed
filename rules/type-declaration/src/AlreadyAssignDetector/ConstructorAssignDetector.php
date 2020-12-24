<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\AlreadyAssignDetector;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class ConstructorAssignDetector extends \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\AlreadyAssignDetector\AbstractAssignDetector
{
    public function isPropertyAssigned(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName) : bool
    {
        $isAssignedInConstructor = \false;
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($propertyName, &$isAssignedInConstructor) : ?int {
            $expr = $this->matchAssignExprToPropertyName($node, $propertyName);
            if ($expr === null) {
                return null;
            }
            // is in constructor?
            $methodName = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
            if ($methodName !== \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT) {
                return null;
            }
            /** @var Assign $assign */
            $assign = $node;
            $isFirstLevelStatement = $assign->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::IS_FIRST_LEVEL_STATEMENT);
            // cannot be nested
            if ($isFirstLevelStatement !== \true) {
                return null;
            }
            $isAssignedInConstructor = \true;
            return \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
        });
        return $isAssignedInConstructor;
    }
}
