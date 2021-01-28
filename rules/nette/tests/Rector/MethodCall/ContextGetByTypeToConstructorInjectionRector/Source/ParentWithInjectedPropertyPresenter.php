<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use RectorPrefix20210128\Nette\Application\IPresenter;
use RectorPrefix20210128\Nette\Application\IResponse;
use RectorPrefix20210128\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \RectorPrefix20210128\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\RectorPrefix20210128\Nette\Application\Request $request) : \RectorPrefix20210128\Nette\Application\IResponse
    {
    }
}
