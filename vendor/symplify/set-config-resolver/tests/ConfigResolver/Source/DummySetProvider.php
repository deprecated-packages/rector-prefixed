<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SetConfigResolver\Tests\ConfigResolver\Source;

use _PhpScopere8e811afab72\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use _PhpScopere8e811afab72\Symplify\SetConfigResolver\Provider\AbstractSetProvider;
use _PhpScopere8e811afab72\Symplify\SetConfigResolver\ValueObject\Set;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class DummySetProvider extends \_PhpScopere8e811afab72\Symplify\SetConfigResolver\Provider\AbstractSetProvider implements \_PhpScopere8e811afab72\Symplify\SetConfigResolver\Contract\SetProviderInterface
{
    /**
     * @var Set[]
     */
    private $sets = [];
    public function __construct()
    {
        $this->sets[] = new \_PhpScopere8e811afab72\Symplify\SetConfigResolver\ValueObject\Set('some_set', new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/../Source/some_set.yaml'));
        $this->sets[] = new \_PhpScopere8e811afab72\Symplify\SetConfigResolver\ValueObject\Set('some_php_set', new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/../Source/some_php_set.php'));
    }
    /**
     * @return Set[]
     */
    public function provide() : array
    {
        return $this->sets;
    }
}
