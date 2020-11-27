<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper26e51eeacccf\Nette\Application\IPresenter;
use _PhpScoper26e51eeacccf\Nette\Application\IResponse;
use _PhpScoper26e51eeacccf\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoper26e51eeacccf\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoper26e51eeacccf\Nette\Application\Request $request) : \_PhpScoper26e51eeacccf\Nette\Application\IResponse
    {
    }
}
