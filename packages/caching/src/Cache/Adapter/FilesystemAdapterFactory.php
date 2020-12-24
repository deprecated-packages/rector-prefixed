<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Caching\Cache\Adapter;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Option;
use _PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider;
final class FilesystemAdapterFactory
{
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->parameterProvider = $parameterProvider;
    }
    public function create() : \_PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter\FilesystemAdapter
    {
        return new \_PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter\FilesystemAdapter(
            // unique per project
            \_PhpScoperb75b35f52b74\Nette\Utils\Strings::webalize(\getcwd()),
            0,
            $this->parameterProvider->provideParameter(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::CACHE_DIR)
        );
    }
}
