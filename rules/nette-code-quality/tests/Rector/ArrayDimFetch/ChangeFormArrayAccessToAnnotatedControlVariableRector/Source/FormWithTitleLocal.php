<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Tests\Rector\ArrayDimFetch\ChangeFormArrayAccessToAnnotatedControlVariableRector\Source;

use RectorPrefix20210312\Nette\Application\UI\Form;
final class FormWithTitleLocal extends \RectorPrefix20210312\Nette\Application\UI\Form
{
    public function __construct()
    {
        $this->addText('title');
    }
}
