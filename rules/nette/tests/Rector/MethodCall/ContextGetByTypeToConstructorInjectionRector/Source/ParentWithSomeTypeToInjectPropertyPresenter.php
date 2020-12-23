<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper0a2ac50786fa\Nette\Application\IPresenter;
use _PhpScoper0a2ac50786fa\Nette\Application\IResponse;
use _PhpScoper0a2ac50786fa\Nette\Application\Request;
class ParentWithSomeTypeToInjectPropertyPresenter implements \_PhpScoper0a2ac50786fa\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    protected $someTypeToInject;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScoper0a2ac50786fa\Nette\Application\Request $request) : \_PhpScoper0a2ac50786fa\Nette\Application\IResponse
    {
    }
}
