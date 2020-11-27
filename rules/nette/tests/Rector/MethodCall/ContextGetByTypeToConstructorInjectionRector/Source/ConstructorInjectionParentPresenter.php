<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoperbd5d0c5f7638\Nette\Application\IPresenter;
use _PhpScoperbd5d0c5f7638\Nette\Application\IResponse;
use _PhpScoperbd5d0c5f7638\Nette\Application\Request;
class ConstructorInjectionParentPresenter implements \_PhpScoperbd5d0c5f7638\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    private $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScoperbd5d0c5f7638\Nette\Application\Request $request) : \_PhpScoperbd5d0c5f7638\Nette\Application\IResponse
    {
    }
}
