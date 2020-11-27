<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper88fe6e0ad041\Nette\Application\IPresenter;
use _PhpScoper88fe6e0ad041\Nette\Application\IResponse;
use _PhpScoper88fe6e0ad041\Nette\Application\Request;
class ParentWithSomeTypeToInjectPropertyPresenter implements \_PhpScoper88fe6e0ad041\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    protected $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScoper88fe6e0ad041\Nette\Application\Request $request) : \_PhpScoper88fe6e0ad041\Nette\Application\IResponse
    {
    }
}
