<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoperb75b35f52b74\Nette\Application\IPresenter;
use _PhpScoperb75b35f52b74\Nette\Application\IResponse;
use _PhpScoperb75b35f52b74\Nette\Application\Request;
class ParentWithSomeTypeToInjectPropertyPresenter implements \_PhpScoperb75b35f52b74\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    protected $someTypeToInject;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScoperb75b35f52b74\Nette\Application\Request $request) : \_PhpScoperb75b35f52b74\Nette\Application\IResponse
    {
    }
}
