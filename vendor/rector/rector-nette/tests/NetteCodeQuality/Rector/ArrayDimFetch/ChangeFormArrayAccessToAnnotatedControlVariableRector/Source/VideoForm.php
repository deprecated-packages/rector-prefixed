<?php

declare (strict_types=1);
namespace Rector\Tests\NetteCodeQuality\Rector\ArrayDimFetch\ChangeFormArrayAccessToAnnotatedControlVariableRector\Source;

use RectorPrefix20210320\Nette\Application\UI\Form;
final class VideoForm extends \RectorPrefix20210320\Nette\Application\UI\Form
{
    public function __construct()
    {
        $this->addCheckboxList('video');
    }
}
