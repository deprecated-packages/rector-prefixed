<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper567b66d83109\Nette\Application\IPresenter;
use _PhpScoper567b66d83109\Nette\Application\IResponse;
use _PhpScoper567b66d83109\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoper567b66d83109\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoper567b66d83109\Nette\Application\Request $request) : \_PhpScoper567b66d83109\Nette\Application\IResponse
    {
    }
}
