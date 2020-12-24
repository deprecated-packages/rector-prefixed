<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Defluent\NodeFactory;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\NetteKdyby\Naming\VariableNaming;
final class VariableFromNewFactory
{
    /**
     * @var VariableNaming
     */
    private $variableNaming;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
    {
        $this->variableNaming = $variableNaming;
    }
    public function create(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_ $new) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable
    {
        $variableName = $this->variableNaming->resolveFromNode($new);
        if ($variableName === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($variableName);
    }
}
