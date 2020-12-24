<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Tests\ConfigResolver\Source;

use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Provider\AbstractSetProvider;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\ValueObject\Set;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class DummySetProvider extends \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Provider\AbstractSetProvider implements \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Contract\SetProviderInterface
{
    /**
     * @var Set[]
     */
    private $sets = [];
    public function __construct()
    {
        $this->sets[] = new \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\ValueObject\Set('some_set', new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/../Source/some_set.yaml'));
        $this->sets[] = new \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\ValueObject\Set('some_php_set', new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/../Source/some_php_set.php'));
    }
    /**
     * @return Set[]
     */
    public function provide() : array
    {
        return $this->sets;
    }
}
