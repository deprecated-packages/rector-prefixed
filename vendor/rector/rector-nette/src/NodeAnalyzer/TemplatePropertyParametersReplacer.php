<?php

declare (strict_types=1);
namespace Rector\Nette\NodeAnalyzer;

use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use Rector\Nette\ValueObject\TemplateParametersAssigns;
final class TemplatePropertyParametersReplacer
{
    /**
     * @return void
     */
    public function replace(\Rector\Nette\ValueObject\TemplateParametersAssigns $magicTemplateParametersAssigns, \PhpParser\Node\Expr\Variable $variable)
    {
        foreach ($magicTemplateParametersAssigns->getTemplateParameterAssigns() as $alwaysTemplateParameterAssign) {
            $arrayDimFetch = new \PhpParser\Node\Expr\ArrayDimFetch($variable, new \PhpParser\Node\Scalar\String_($alwaysTemplateParameterAssign->getParameterName()));
            $assign = $alwaysTemplateParameterAssign->getAssign();
            $assign->var = $arrayDimFetch;
        }
    }
}
