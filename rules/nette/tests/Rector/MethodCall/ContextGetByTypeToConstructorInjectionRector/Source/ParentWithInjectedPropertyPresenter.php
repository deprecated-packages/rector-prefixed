<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper267b3276efc2\Nette\Application\IPresenter;
use _PhpScoper267b3276efc2\Nette\Application\IResponse;
use _PhpScoper267b3276efc2\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoper267b3276efc2\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoper267b3276efc2\Nette\Application\Request $request) : \_PhpScoper267b3276efc2\Nette\Application\IResponse
    {
    }
}
