<?php

declare(strict_types=1);

namespace Rector\Nette\NodeAnalyzer;

use PhpParser\Node\Expr\Variable;
use Rector\Nette\ValueObject\TemplateParametersAssigns;

/**
 * Replaces:
 *
 * if (...) { $this->template->key = 'some'; } else { $this->template->key = 'another'; }
 *
 * ↓
 *
 * if (...) { $key = 'some'; } else { $key = 'another'; }
 */
final class ConditionalTemplateAssignReplacer
{
    /**
     * @return void
     */
    public function processClassMethod(TemplateParametersAssigns $templateParametersAssigns)
    {
        foreach ($templateParametersAssigns->getConditionalTemplateParameterAssign() as $conditionalTemplateParameterAssign) {
            $assign = $conditionalTemplateParameterAssign->getAssign();
            $assign->var = new Variable($conditionalTemplateParameterAssign->getParameterName());
        }
    }
}
