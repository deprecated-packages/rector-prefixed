<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\MethodCall\NetteFormToSymfonyFormRector\Source;

use _PhpScoper26e51eeacccf\Nette\Application\IPresenter;
use _PhpScoper26e51eeacccf\Nette\Application\IResponse;
use _PhpScoper26e51eeacccf\Nette\Application\Request;
abstract class NettePresenter implements \_PhpScoper26e51eeacccf\Nette\Application\IPresenter
{
    public function run(\_PhpScoper26e51eeacccf\Nette\Application\Request $request) : \_PhpScoper26e51eeacccf\Nette\Application\IResponse
    {
    }
}
