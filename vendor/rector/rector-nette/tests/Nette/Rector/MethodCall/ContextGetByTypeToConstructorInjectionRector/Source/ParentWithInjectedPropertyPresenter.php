<?php

declare (strict_types=1);
namespace Rector\Tests\Nette\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use RectorPrefix20210319\Nette\Application\IPresenter;
use RectorPrefix20210319\Nette\Application\IResponse;
use RectorPrefix20210319\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \RectorPrefix20210319\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\RectorPrefix20210319\Nette\Application\Request $request) : \RectorPrefix20210319\Nette\Application\IResponse
    {
    }
}
