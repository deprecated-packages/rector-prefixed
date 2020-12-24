<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper2a4e7ab1ecbc\Nette\Application\IPresenter;
use _PhpScoper2a4e7ab1ecbc\Nette\Application\IResponse;
use _PhpScoper2a4e7ab1ecbc\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoper2a4e7ab1ecbc\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoper2a4e7ab1ecbc\Nette\Application\Request $request) : \_PhpScoper2a4e7ab1ecbc\Nette\Application\IResponse
    {
    }
}
