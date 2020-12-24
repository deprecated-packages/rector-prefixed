<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Tests\ConfigResolver\Source;

use _PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Provider\AbstractSetProvider;
use _PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\ValueObject\Set;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class DummySetProvider extends \_PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Provider\AbstractSetProvider implements \_PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Contract\SetProviderInterface
{
    /**
     * @var Set[]
     */
    private $sets = [];
    public function __construct()
    {
        $this->sets[] = new \_PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\ValueObject\Set('some_set', new \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/../Source/some_set.yaml'));
        $this->sets[] = new \_PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\ValueObject\Set('some_php_set', new \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/../Source/some_php_set.php'));
    }
    /**
     * @return Set[]
     */
    public function provide() : array
    {
        return $this->sets;
    }
}
