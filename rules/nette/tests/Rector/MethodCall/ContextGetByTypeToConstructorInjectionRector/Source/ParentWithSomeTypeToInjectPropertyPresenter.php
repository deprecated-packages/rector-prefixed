<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper006a73f0e455\Nette\Application\IPresenter;
use _PhpScoper006a73f0e455\Nette\Application\IResponse;
use _PhpScoper006a73f0e455\Nette\Application\Request;
class ParentWithSomeTypeToInjectPropertyPresenter implements \_PhpScoper006a73f0e455\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    protected $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScoper006a73f0e455\Nette\Application\Request $request) : \_PhpScoper006a73f0e455\Nette\Application\IResponse
    {
    }
}
