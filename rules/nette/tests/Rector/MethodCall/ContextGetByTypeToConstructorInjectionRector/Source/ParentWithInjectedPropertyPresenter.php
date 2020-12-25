<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoperf18a0c41e2d2\Nette\Application\IPresenter;
use _PhpScoperf18a0c41e2d2\Nette\Application\IResponse;
use _PhpScoperf18a0c41e2d2\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoperf18a0c41e2d2\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoperf18a0c41e2d2\Nette\Application\Request $request) : \_PhpScoperf18a0c41e2d2\Nette\Application\IResponse
    {
    }
}
