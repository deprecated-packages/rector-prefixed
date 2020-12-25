<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper50d83356d739\Nette\Application\IPresenter;
use _PhpScoper50d83356d739\Nette\Application\IResponse;
use _PhpScoper50d83356d739\Nette\Application\Request;
class ConstructorInjectionParentPresenter implements \_PhpScoper50d83356d739\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    private $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScoper50d83356d739\Nette\Application\Request $request) : \_PhpScoper50d83356d739\Nette\Application\IResponse
    {
    }
}
