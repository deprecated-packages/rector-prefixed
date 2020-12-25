<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper5edc98a7cce2\Nette\Application\IPresenter;
use _PhpScoper5edc98a7cce2\Nette\Application\IResponse;
use _PhpScoper5edc98a7cce2\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoper5edc98a7cce2\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoper5edc98a7cce2\Nette\Application\Request $request) : \_PhpScoper5edc98a7cce2\Nette\Application\IResponse
    {
    }
}
