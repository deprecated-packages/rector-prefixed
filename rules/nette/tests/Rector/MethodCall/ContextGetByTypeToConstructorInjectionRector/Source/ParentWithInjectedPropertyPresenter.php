<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper006a73f0e455\Nette\Application\IPresenter;
use _PhpScoper006a73f0e455\Nette\Application\IResponse;
use _PhpScoper006a73f0e455\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoper006a73f0e455\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoper006a73f0e455\Nette\Application\Request $request) : \_PhpScoper006a73f0e455\Nette\Application\IResponse
    {
    }
}
