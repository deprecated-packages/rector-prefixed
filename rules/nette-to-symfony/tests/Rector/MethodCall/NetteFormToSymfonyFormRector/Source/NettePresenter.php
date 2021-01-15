<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\MethodCall\NetteFormToSymfonyFormRector\Source;

use RectorPrefix20210115\Nette\Application\IPresenter;
use RectorPrefix20210115\Nette\Application\IResponse;
use RectorPrefix20210115\Nette\Application\Request;
abstract class NettePresenter implements \RectorPrefix20210115\Nette\Application\IPresenter
{
    public function run(\RectorPrefix20210115\Nette\Application\Request $request) : \RectorPrefix20210115\Nette\Application\IResponse
    {
    }
}
