<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use RectorPrefix20201231\Nette\Application\IPresenter;
use RectorPrefix20201231\Nette\Application\IResponse;
use RectorPrefix20201231\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \RectorPrefix20201231\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\RectorPrefix20201231\Nette\Application\Request $request) : \RectorPrefix20201231\Nette\Application\IResponse
    {
    }
}
