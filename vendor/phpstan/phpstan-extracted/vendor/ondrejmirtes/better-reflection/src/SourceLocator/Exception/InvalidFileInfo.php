<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception;

use RuntimeException;
use function get_class;
use function gettype;
use function is_object;
use function sprintf;
class InvalidFileInfo extends \RuntimeException
{
    /**
     * @param mixed $nonSplFileInfo
     */
    public static function fromNonSplFileInfo($nonSplFileInfo) : self
    {
        return new self(\sprintf('Expected an iterator of SplFileInfo instances, %s given instead', \is_object($nonSplFileInfo) ? \get_class($nonSplFileInfo) : \gettype($nonSplFileInfo)));
    }
}