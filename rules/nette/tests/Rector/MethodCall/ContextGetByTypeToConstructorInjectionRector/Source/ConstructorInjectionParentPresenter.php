<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoperabd03f0baf05\Nette\Application\IPresenter;
use _PhpScoperabd03f0baf05\Nette\Application\IResponse;
use _PhpScoperabd03f0baf05\Nette\Application\Request;
class ConstructorInjectionParentPresenter implements \_PhpScoperabd03f0baf05\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    private $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScoperabd03f0baf05\Nette\Application\Request $request) : \_PhpScoperabd03f0baf05\Nette\Application\IResponse
    {
    }
}
