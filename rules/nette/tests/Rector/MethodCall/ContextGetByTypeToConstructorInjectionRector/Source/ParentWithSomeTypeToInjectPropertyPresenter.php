<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper26e51eeacccf\Nette\Application\IPresenter;
use _PhpScoper26e51eeacccf\Nette\Application\IResponse;
use _PhpScoper26e51eeacccf\Nette\Application\Request;
class ParentWithSomeTypeToInjectPropertyPresenter implements \_PhpScoper26e51eeacccf\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    protected $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScoper26e51eeacccf\Nette\Application\Request $request) : \_PhpScoper26e51eeacccf\Nette\Application\IResponse
    {
    }
}
