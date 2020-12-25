<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper8b9c402c5f32\Nette\Application\IPresenter;
use _PhpScoper8b9c402c5f32\Nette\Application\IResponse;
use _PhpScoper8b9c402c5f32\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoper8b9c402c5f32\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoper8b9c402c5f32\Nette\Application\Request $request) : \_PhpScoper8b9c402c5f32\Nette\Application\IResponse
    {
    }
}
