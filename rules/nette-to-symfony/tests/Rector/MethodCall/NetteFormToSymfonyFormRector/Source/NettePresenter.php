<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteToSymfony\Tests\Rector\MethodCall\NetteFormToSymfonyFormRector\Source;

use _PhpScoperb75b35f52b74\Nette\Application\IPresenter;
use _PhpScoperb75b35f52b74\Nette\Application\IResponse;
use _PhpScoperb75b35f52b74\Nette\Application\Request;
abstract class NettePresenter implements \_PhpScoperb75b35f52b74\Nette\Application\IPresenter
{
    public function run(\_PhpScoperb75b35f52b74\Nette\Application\Request $request) : \_PhpScoperb75b35f52b74\Nette\Application\IResponse
    {
    }
}
