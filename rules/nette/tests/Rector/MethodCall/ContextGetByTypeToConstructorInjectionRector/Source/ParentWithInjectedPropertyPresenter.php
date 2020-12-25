<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoperbf340cb0be9d\Nette\Application\IPresenter;
use _PhpScoperbf340cb0be9d\Nette\Application\IResponse;
use _PhpScoperbf340cb0be9d\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoperbf340cb0be9d\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoperbf340cb0be9d\Nette\Application\Request $request) : \_PhpScoperbf340cb0be9d\Nette\Application\IResponse
    {
    }
}
