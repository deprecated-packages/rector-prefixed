<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper8b9c402c5f32\Nette\Application\IPresenter;
use _PhpScoper8b9c402c5f32\Nette\Application\IResponse;
use _PhpScoper8b9c402c5f32\Nette\Application\Request;
class ParentWithSomeTypeToInjectPropertyPresenter implements \_PhpScoper8b9c402c5f32\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    protected $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScoper8b9c402c5f32\Nette\Application\Request $request) : \_PhpScoper8b9c402c5f32\Nette\Application\IResponse
    {
    }
}
