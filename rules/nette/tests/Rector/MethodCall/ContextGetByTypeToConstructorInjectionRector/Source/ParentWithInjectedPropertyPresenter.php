<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper5b8c9e9ebd21\Nette\Application\IPresenter;
use _PhpScoper5b8c9e9ebd21\Nette\Application\IResponse;
use _PhpScoper5b8c9e9ebd21\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoper5b8c9e9ebd21\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoper5b8c9e9ebd21\Nette\Application\Request $request) : \_PhpScoper5b8c9e9ebd21\Nette\Application\IResponse
    {
    }
}
