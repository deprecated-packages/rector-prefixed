<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\TraitUseAdaptation;

use _PhpScoper0a6b37af0871\PhpParser\Node;
class Precedence extends \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\TraitUseAdaptation
{
    /** @var Node\Name[] Overwritten traits */
    public $insteadof;
    /**
     * Constructs a trait use precedence adaptation node.
     *
     * @param Node\Name              $trait       Trait name
     * @param string|Node\Identifier $method      Method name
     * @param Node\Name[]            $insteadof   Overwritten traits
     * @param array                  $attributes  Additional attributes
     */
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Name $trait, $method, array $insteadof, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->trait = $trait;
        $this->method = \is_string($method) ? new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier($method) : $method;
        $this->insteadof = $insteadof;
    }
    public function getSubNodeNames() : array
    {
        return ['trait', 'method', 'insteadof'];
    }
    public function getType() : string
    {
        return 'Stmt_TraitUseAdaptation_Precedence';
    }
}
