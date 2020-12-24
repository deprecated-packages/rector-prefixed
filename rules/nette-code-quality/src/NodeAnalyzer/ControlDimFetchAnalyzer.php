<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\NodeAnalyzer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;
final class ControlDimFetchAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function matchNameOnFormOrControlVariable(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?string
    {
        return $this->matchNameOnVariableTypes($node, ['_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\UI\\Form']);
    }
    public function matchNameOnControlVariable(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?string
    {
        return $this->matchNameOnVariableTypes($node, ['_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\UI\\Control']);
    }
    public function matchName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?string
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch) {
            return null;
        }
        if (!$this->isVariableTypes($node->var, ['_PhpScoper2a4e7ab1ecbc\\Nette\\ComponentModel\\IContainer'])) {
            return null;
        }
        if (!$node->dim instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_) {
            return null;
        }
        return $node->dim->value;
    }
    /**
     * @param string[] $types
     */
    private function matchNameOnVariableTypes(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, array $types) : ?string
    {
        $matchedName = $this->matchName($node);
        if ($matchedName === null) {
            return null;
        }
        /** @var Assign $node */
        if (!$this->isVariableTypes($node->var, $types)) {
            return null;
        }
        return $matchedName;
    }
    /**
     * @param string[] $types
     */
    private function isVariableTypes(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, array $types) : bool
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
            return \false;
        }
        foreach ($types as $type) {
            if ($this->nodeTypeResolver->isObjectTypeOrNullableObjectType($node, $type)) {
                return \true;
            }
        }
        return \false;
    }
}
