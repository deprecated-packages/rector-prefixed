<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use RectorPrefix20210111\Nette\Application\IPresenter;
use RectorPrefix20210111\Nette\Application\IResponse;
use RectorPrefix20210111\Nette\Application\Request;
class ParentWithSomeTypeToInjectPropertyPresenter implements \RectorPrefix20210111\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    protected $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\RectorPrefix20210111\Nette\Application\Request $request) : \RectorPrefix20210111\Nette\Application\IResponse
    {
    }
}
