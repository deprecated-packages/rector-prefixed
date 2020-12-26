<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\MethodCall\NetteFormToSymfonyFormRector\Source;

use RectorPrefix2020DecSat\Nette\Application\IPresenter;
use RectorPrefix2020DecSat\Nette\Application\IResponse;
use RectorPrefix2020DecSat\Nette\Application\Request;
abstract class NettePresenter implements \RectorPrefix2020DecSat\Nette\Application\IPresenter
{
    public function run(\RectorPrefix2020DecSat\Nette\Application\Request $request) : \RectorPrefix2020DecSat\Nette\Application\IResponse
    {
    }
}
