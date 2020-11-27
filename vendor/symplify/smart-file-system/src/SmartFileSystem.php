<?php

declare (strict_types=1);
namespace Symplify\SmartFileSystem;

use _PhpScopera143bcca66cb\Nette\Utils\Html;
use _PhpScopera143bcca66cb\Nette\Utils\Strings;
use _PhpScopera143bcca66cb\Symfony\Component\Filesystem\Exception\IOException;
use _PhpScopera143bcca66cb\Symfony\Component\Filesystem\Filesystem;
final class SmartFileSystem extends \_PhpScopera143bcca66cb\Symfony\Component\Filesystem\Filesystem
{
    /**
     * @var string
     * @see https://regex101.com/r/tx6eyw/1
     */
    private const BEFORE_COLLON_REGEX = '#^\\w+\\(.*?\\): #';
    /**
     * @see https://github.com/symfony/filesystem/pull/4/files
     */
    public function readFile(string $filename) : string
    {
        $source = @\file_get_contents($filename);
        if (!$source) {
            $message = \sprintf('Failed to read "%s" file: "%s"', $filename, $this->getLastError());
            throw new \_PhpScopera143bcca66cb\Symfony\Component\Filesystem\Exception\IOException($message, 0, null, $filename);
        }
        return $source;
    }
    public function readFileToSmartFileInfo(string $filename) : \Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \Symplify\SmartFileSystem\SmartFileInfo($filename);
    }
    /**
     * Converts given HTML code to plain text
     * @source https://github.com/nette/utils/blob/e7bd59f1dd860d25dbbb1ac720dddd0fa1388f4c/src/Utils/Html.php#L325-L331
     */
    public function htmlToText(string $html) : string
    {
        return \html_entity_decode(\strip_tags($html), \ENT_QUOTES | \ENT_HTML5, 'UTF-8');
    }
    /**
     * Returns the last PHP error as plain string.
     * @source https://github.com/nette/utils/blob/ab8eea12b8aacc7ea5bdafa49b711c2988447994/src/Utils/Helpers.php#L31-L40
     */
    private function getLastError() : string
    {
        $message = \error_get_last()['message'] ?? '';
        $message = \ini_get('html_errors') ? $this->htmlToText($message) : $message;
        return \_PhpScopera143bcca66cb\Nette\Utils\Strings::replace($message, self::BEFORE_COLLON_REGEX);
    }
}
