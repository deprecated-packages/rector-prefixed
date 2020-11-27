<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoperbd5d0c5f7638\Nette\Application\IPresenter;
use _PhpScoperbd5d0c5f7638\Nette\Application\IResponse;
use _PhpScoperbd5d0c5f7638\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScoperbd5d0c5f7638\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScoperbd5d0c5f7638\Nette\Application\Request $request) : \_PhpScoperbd5d0c5f7638\Nette\Application\IResponse
    {
    }
}
