<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use RectorPrefix20201226\Nette\Application\IPresenter;
use RectorPrefix20201226\Nette\Application\IResponse;
use RectorPrefix20201226\Nette\Application\Request;
class ConstructorInjectionParentPresenter implements \RectorPrefix20201226\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    private $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\RectorPrefix20201226\Nette\Application\Request $request) : \RectorPrefix20201226\Nette\Application\IResponse
    {
    }
}
