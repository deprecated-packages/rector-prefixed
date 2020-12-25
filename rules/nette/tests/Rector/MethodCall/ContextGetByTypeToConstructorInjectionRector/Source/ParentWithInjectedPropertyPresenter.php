<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoperfce0de0de1ce\Nette\Application\IPresenter;
use _PhpScoperfce0de0de1ce\Nette\Application\IResponse;
use _PhpScoperfce0de0de1ce\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoperfce0de0de1ce\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoperfce0de0de1ce\Nette\Application\Request $request) : \_PhpScoperfce0de0de1ce\Nette\Application\IResponse
    {
    }
}
