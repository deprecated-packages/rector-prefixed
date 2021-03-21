<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\ArrayDimFetch\ChangeFormArrayAccessToAnnotatedControlVariableRector\Source;

use RectorPrefix20210321\Nette\Application\UI\Form;
final class SomeFormFactory
{
    public function createForm() : \RectorPrefix20210321\Nette\Application\UI\Form
    {
        $form = new \RectorPrefix20210321\Nette\Application\UI\Form();
        $form->addSelect('items');
        return $form;
    }
}
