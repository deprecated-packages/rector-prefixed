<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Defluent\NodeFactory;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby\Naming\VariableNaming;
final class VariableFromNewFactory
{
    /**
     * @var VariableNaming
     */
    private $variableNaming;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
    {
        $this->variableNaming = $variableNaming;
    }
    public function create(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_ $new) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable
    {
        $variableName = $this->variableNaming->resolveFromNode($new);
        if ($variableName === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable($variableName);
    }
}
