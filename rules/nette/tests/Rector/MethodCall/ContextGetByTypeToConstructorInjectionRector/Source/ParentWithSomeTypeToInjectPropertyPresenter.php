<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use RectorPrefix2020DecSat\Nette\Application\IPresenter;
use RectorPrefix2020DecSat\Nette\Application\IResponse;
use RectorPrefix2020DecSat\Nette\Application\Request;
class ParentWithSomeTypeToInjectPropertyPresenter implements \RectorPrefix2020DecSat\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    protected $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\RectorPrefix2020DecSat\Nette\Application\Request $request) : \RectorPrefix2020DecSat\Nette\Application\IResponse
    {
    }
}
