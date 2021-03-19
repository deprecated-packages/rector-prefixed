<?php

declare (strict_types=1);
namespace Rector\Tests\Nette\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use RectorPrefix20210319\Nette\Application\IPresenter;
use RectorPrefix20210319\Nette\Application\IResponse;
use RectorPrefix20210319\Nette\Application\Request;
class ParentWithSomeTypeToInjectPropertyPresenter implements \RectorPrefix20210319\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    protected $someTypeToInject;
    public function __construct(\Rector\Tests\Nette\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\RectorPrefix20210319\Nette\Application\Request $request) : \RectorPrefix20210319\Nette\Application\IResponse
    {
    }
}
