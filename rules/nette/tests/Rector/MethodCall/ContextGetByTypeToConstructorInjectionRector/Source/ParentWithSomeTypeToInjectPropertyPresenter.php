<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper2a4e7ab1ecbc\Nette\Application\IPresenter;
use _PhpScoper2a4e7ab1ecbc\Nette\Application\IResponse;
use _PhpScoper2a4e7ab1ecbc\Nette\Application\Request;
class ParentWithSomeTypeToInjectPropertyPresenter implements \_PhpScoper2a4e7ab1ecbc\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    protected $someTypeToInject;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScoper2a4e7ab1ecbc\Nette\Application\Request $request) : \_PhpScoper2a4e7ab1ecbc\Nette\Application\IResponse
    {
    }
}
