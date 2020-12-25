<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoperf18a0c41e2d2\Nette\Application\IPresenter;
use _PhpScoperf18a0c41e2d2\Nette\Application\IResponse;
use _PhpScoperf18a0c41e2d2\Nette\Application\Request;
class ParentWithSomeTypeToInjectPropertyPresenter implements \_PhpScoperf18a0c41e2d2\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    protected $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScoperf18a0c41e2d2\Nette\Application\Request $request) : \_PhpScoperf18a0c41e2d2\Nette\Application\IResponse
    {
    }
}
