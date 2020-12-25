<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper17db12703726\Nette\Application\IPresenter;
use _PhpScoper17db12703726\Nette\Application\IResponse;
use _PhpScoper17db12703726\Nette\Application\Request;
class ParentWithSomeTypeToInjectPropertyPresenter implements \_PhpScoper17db12703726\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    protected $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScoper17db12703726\Nette\Application\Request $request) : \_PhpScoper17db12703726\Nette\Application\IResponse
    {
    }
}
