<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper0a6b37af0871\Nette\Application\IPresenter;
use _PhpScoper0a6b37af0871\Nette\Application\IResponse;
use _PhpScoper0a6b37af0871\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoper0a6b37af0871\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoper0a6b37af0871\Nette\Application\Request $request) : \_PhpScoper0a6b37af0871\Nette\Application\IResponse
    {
    }
}
