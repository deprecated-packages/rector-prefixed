<?php

declare(strict_types=1);

namespace Rector\Nette\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use PHPStan\Type\ObjectType;
use Rector\NodeTypeResolver\NodeTypeResolver;

final class ControlDimFetchAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;

    public function __construct(NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }

    /**
     * @return string|null
     */
    public function matchNameOnFormOrControlVariable(Node $node)
    {
        return $this->matchNameOnVariableType($node, new ObjectType('Nette\Application\UI\Form'));
    }

    /**
     * @return string|null
     */
    public function matchNameOnControlVariable(Node $node)
    {
        return $this->matchNameOnVariableType($node, new ObjectType('Nette\Application\UI\Control'));
    }

    /**
     * @return string|null
     */
    public function matchName(Node $node)
    {
        if (! $node instanceof ArrayDimFetch) {
            return null;
        }

        if (! $this->isVariableTypes($node->var, [new ObjectType('Nette\ComponentModel\IContainer')])) {
            return null;
        }

        if (! $node->dim instanceof String_) {
            return null;
        }

        return $node->dim->value;
    }

    /**
     * @return string|null
     */
    private function matchNameOnVariableType(Node $node, ObjectType $objectType)
    {
        $matchedName = $this->matchName($node);
        if ($matchedName === null) {
            return null;
        }

        /** @var Assign $node */
        if (! $this->isVariableTypes($node->var, [$objectType])) {
            return null;
        }

        return $matchedName;
    }

    /**
     * @param ObjectType[] $objectTypes
     */
    private function isVariableTypes(Node $node, array $objectTypes): bool
    {
        if (! $node instanceof Variable) {
            return false;
        }

        foreach ($objectTypes as $objectType) {
            if ($this->nodeTypeResolver->isObjectType($node, $objectType)) {
                return true;
            }
        }

        return false;
    }
}
