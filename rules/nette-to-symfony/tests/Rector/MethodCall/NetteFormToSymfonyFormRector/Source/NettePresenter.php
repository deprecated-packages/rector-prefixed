<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\MethodCall\NetteFormToSymfonyFormRector\Source;

use _PhpScopera143bcca66cb\Nette\Application\IPresenter;
use _PhpScopera143bcca66cb\Nette\Application\IResponse;
use _PhpScopera143bcca66cb\Nette\Application\Request;
abstract class NettePresenter implements \_PhpScopera143bcca66cb\Nette\Application\IPresenter
{
    public function run(\_PhpScopera143bcca66cb\Nette\Application\Request $request) : \_PhpScopera143bcca66cb\Nette\Application\IResponse
    {
    }
}
