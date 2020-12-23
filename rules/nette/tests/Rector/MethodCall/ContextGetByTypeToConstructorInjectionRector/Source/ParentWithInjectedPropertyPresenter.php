<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper0a2ac50786fa\Nette\Application\IPresenter;
use _PhpScoper0a2ac50786fa\Nette\Application\IResponse;
use _PhpScoper0a2ac50786fa\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoper0a2ac50786fa\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoper0a2ac50786fa\Nette\Application\Request $request) : \_PhpScoper0a2ac50786fa\Nette\Application\IResponse
    {
    }
}
