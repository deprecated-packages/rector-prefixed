<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper17db12703726\Nette\Application\IPresenter;
use _PhpScoper17db12703726\Nette\Application\IResponse;
use _PhpScoper17db12703726\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoper17db12703726\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoper17db12703726\Nette\Application\Request $request) : \_PhpScoper17db12703726\Nette\Application\IResponse
    {
    }
}
