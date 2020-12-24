<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
final class ControlDimFetchAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function matchNameOnFormOrControlVariable(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        return $this->matchNameOnVariableTypes($node, ['_PhpScoperb75b35f52b74\\Nette\\Application\\UI\\Form']);
    }
    public function matchNameOnControlVariable(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        return $this->matchNameOnVariableTypes($node, ['_PhpScoperb75b35f52b74\\Nette\\Application\\UI\\Control']);
    }
    public function matchName(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch) {
            return null;
        }
        if (!$this->isVariableTypes($node->var, ['_PhpScoperb75b35f52b74\\Nette\\ComponentModel\\IContainer'])) {
            return null;
        }
        if (!$node->dim instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            return null;
        }
        return $node->dim->value;
    }
    /**
     * @param string[] $types
     */
    private function matchNameOnVariableTypes(\_PhpScoperb75b35f52b74\PhpParser\Node $node, array $types) : ?string
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
    private function isVariableTypes(\_PhpScoperb75b35f52b74\PhpParser\Node $node, array $types) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
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
