<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Caching\Cache\Adapter;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider;
final class FilesystemAdapterFactory
{
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->parameterProvider = $parameterProvider;
    }
    public function create() : \_PhpScopere8e811afab72\Symfony\Component\Cache\Adapter\FilesystemAdapter
    {
        return new \_PhpScopere8e811afab72\Symfony\Component\Cache\Adapter\FilesystemAdapter(
            // unique per project
            \_PhpScopere8e811afab72\Nette\Utils\Strings::webalize(\getcwd()),
            0,
            $this->parameterProvider->provideParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::CACHE_DIR)
        );
    }
}
