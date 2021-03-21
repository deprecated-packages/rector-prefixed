<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\ArrayDimFetch\ChangeFormArrayAccessToAnnotatedControlVariableRector\Source;

use RectorPrefix20210321\Nette\Application\UI\Form;
final class VideoForm extends \RectorPrefix20210321\Nette\Application\UI\Form
{
    public function __construct()
    {
        $this->addCheckboxList('video');
    }
}
