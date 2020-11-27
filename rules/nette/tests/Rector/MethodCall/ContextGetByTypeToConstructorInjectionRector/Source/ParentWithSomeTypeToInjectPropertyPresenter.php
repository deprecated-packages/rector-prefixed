<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScopera143bcca66cb\Nette\Application\IPresenter;
use _PhpScopera143bcca66cb\Nette\Application\IResponse;
use _PhpScopera143bcca66cb\Nette\Application\Request;
class ParentWithSomeTypeToInjectPropertyPresenter implements \_PhpScopera143bcca66cb\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    protected $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScopera143bcca66cb\Nette\Application\Request $request) : \_PhpScopera143bcca66cb\Nette\Application\IResponse
    {
    }
}
