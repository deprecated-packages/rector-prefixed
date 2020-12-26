<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use RectorPrefix2020DecSat\Nette\Application\IPresenter;
use RectorPrefix2020DecSat\Nette\Application\IResponse;
use RectorPrefix2020DecSat\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \RectorPrefix2020DecSat\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\RectorPrefix2020DecSat\Nette\Application\Request $request) : \RectorPrefix2020DecSat\Nette\Application\IResponse
    {
    }
}
