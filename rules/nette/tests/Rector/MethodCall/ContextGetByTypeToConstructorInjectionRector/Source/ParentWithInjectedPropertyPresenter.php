<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoperb75b35f52b74\Nette\Application\IPresenter;
use _PhpScoperb75b35f52b74\Nette\Application\IResponse;
use _PhpScoperb75b35f52b74\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoperb75b35f52b74\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoperb75b35f52b74\Nette\Application\Request $request) : \_PhpScoperb75b35f52b74\Nette\Application\IResponse
    {
    }
}
