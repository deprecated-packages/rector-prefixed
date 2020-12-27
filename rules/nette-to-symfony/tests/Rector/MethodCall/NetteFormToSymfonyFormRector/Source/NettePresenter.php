<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\MethodCall\NetteFormToSymfonyFormRector\Source;

use RectorPrefix20201227\Nette\Application\IPresenter;
use RectorPrefix20201227\Nette\Application\IResponse;
use RectorPrefix20201227\Nette\Application\Request;
abstract class NettePresenter implements \RectorPrefix20201227\Nette\Application\IPresenter
{
    public function run(\RectorPrefix20201227\Nette\Application\Request $request) : \RectorPrefix20201227\Nette\Application\IResponse
    {
    }
}
