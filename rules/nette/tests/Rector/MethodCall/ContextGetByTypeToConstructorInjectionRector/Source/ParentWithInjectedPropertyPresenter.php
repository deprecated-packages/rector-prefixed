<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper50d83356d739\Nette\Application\IPresenter;
use _PhpScoper50d83356d739\Nette\Application\IResponse;
use _PhpScoper50d83356d739\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoper50d83356d739\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoper50d83356d739\Nette\Application\Request $request) : \_PhpScoper50d83356d739\Nette\Application\IResponse
    {
    }
}
