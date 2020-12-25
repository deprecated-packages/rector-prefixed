<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoperfce0de0de1ce\Nette\Application\IPresenter;
use _PhpScoperfce0de0de1ce\Nette\Application\IResponse;
use _PhpScoperfce0de0de1ce\Nette\Application\Request;
class ParentWithSomeTypeToInjectPropertyPresenter implements \_PhpScoperfce0de0de1ce\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    protected $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScoperfce0de0de1ce\Nette\Application\Request $request) : \_PhpScoperfce0de0de1ce\Nette\Application\IResponse
    {
    }
}
