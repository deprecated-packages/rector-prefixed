<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
final class ParamAndArg
{
    /**
     * @var Variable
     */
    private $variable;
    /**
     * @var Type|null
     */
    private $type;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type)
    {
        $this->variable = $variable;
        $this->type = $type;
    }
    public function getVariable() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable
    {
        return $this->variable;
    }
    public function getType() : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->type;
    }
}
