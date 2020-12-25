<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoperbf340cb0be9d\Nette\Application\IPresenter;
use _PhpScoperbf340cb0be9d\Nette\Application\IResponse;
use _PhpScoperbf340cb0be9d\Nette\Application\Request;
class ConstructorInjectionParentPresenter implements \_PhpScoperbf340cb0be9d\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    private $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScoperbf340cb0be9d\Nette\Application\Request $request) : \_PhpScoperbf340cb0be9d\Nette\Application\IResponse
    {
    }
}
