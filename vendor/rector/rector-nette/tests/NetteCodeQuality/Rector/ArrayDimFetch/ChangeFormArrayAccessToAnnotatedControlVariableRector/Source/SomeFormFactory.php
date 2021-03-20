<?php

declare (strict_types=1);
namespace Rector\Tests\NetteCodeQuality\Rector\ArrayDimFetch\ChangeFormArrayAccessToAnnotatedControlVariableRector\Source;

use RectorPrefix20210320\Nette\Application\UI\Form;
final class SomeFormFactory
{
    public function createForm() : \RectorPrefix20210320\Nette\Application\UI\Form
    {
        $form = new \RectorPrefix20210320\Nette\Application\UI\Form();
        $form->addSelect('items');
        return $form;
    }
}
