<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Printer;

use RectorPrefix20210119\Nette\Utils\Strings;
final class ContentPatcher
{
    /**
     * @see https://regex101.com/r/cLgjQf/3
     * @var string
     */
    public const VALID_ANNOTATION_STRING_REGEX = '#\\*\\s+@.*".{1,}"}\\)#';
    /**
     * @see https://regex101.com/r/BhxeM8/3
     * @var string
     */
    public const INVALID_ANNOTATION_STRING_REGEX = '#\\*\\s+@.*.{1,}[^"]}\\)#';
    /**
     * @see https://regex101.com/r/wpVS09/1
     * @var string
     */
    public const VALID_ANNOTATION_ROUTE_REGEX = '#\\*\\s+@.*:\\s?".{1,}"}\\)#';
    /**
     * @see https://regex101.com/r/cIgWGi/1
     * @var string
     */
    public const INVALID_ANNOTATION_ROUTE_REGEX = '#\\*\\s+@.*=\\s?".{1,}"}\\)#';
    /**
     * @see https://regex101.com/r/nCPUz9/2
     * @var string
     */
    public const VALID_ANNOTATION_COMMENT_REGEX = '#\\*\\s+@.*="[^"]*"}\\)#';
    /**
     * @see https://regex101.com/r/xPg2yo/1
     * @var string
     */
    public const INVALID_ANNOTATION_COMMENT_REGEX = '#\\*\\s+@.*=".*"}\\)#';
    /**
     * @see https://regex101.com/r/5HT5AW/7
     * @var string
     */
    public const VALID_ANNOTATION_CONSTRAINT_REGEX = '#\\*\\s+@.*\\(?[\\s\\*]{0,}.*\\s{0,}={(\\s{0,}\\*?\\s{0,}".*",?){1,}[\\s*]+}[\\s\\*]{1,}\\)[\\s\\*}\\)]{0,}#';
    /**
     * @see https://regex101.com/r/U8KzfW/7
     * @var string
     */
    public const INVALID_ANNOTATION_CONSTRAINT_REGEX = '#\\*\\s+@.*\\(?[\\s\\*]{0,}.*\\s{0,}={[^"].*(,[\\s+\\*]+.*)?}[\\s\\*]{1,}\\)[\\s\\*}\\)]{0,}#';
    /**
     * @see https://regex101.com/r/rbCG9a/3
     * @var string
     */
    public const VALID_ANNOTATION_ROUTE_OPTION_REGEX = '#\\*\\s+@.*={(\\s{0,}".*"\\s{0,}=\\s{0,}[^",]*\\s{0,},?){1,}}.*\\)#';
    /**
     * @see https://regex101.com/r/Kl3Ot1/3
     * @var string
     */
    public const INVALID_ANNOTATION_ROUTE_OPTION_REGEX = '#\\*\\s+@.*={([^"]*=[^"]*,?){1,}[^,]}.*\\)#';
    /**
     * @see https://regex101.com/r/Hm2idk/1
     * @var string
     */
    public const VALID_ANNOTATION_ROUTE_LOCALIZATION_REGEX = '#^\\s+\\/\\*\\*\\s+\\s+\\*\\s+@.*\\({(\\s+\\*\\s{0,}".*":\\s{0,}".*",?){1,}\\s+\\*\\s{0,}[^,]}.*\\)\\s+\\*\\/#msU';
    /**
     * @see https://regex101.com/r/qVOGbC/2
     * @var string
     */
    public const INVALID_ANNOTATION_ROUTE_LOCALIZATION_REGEX = '#^\\s+\\/\\*\\*\\s+\\s+\\*\\s+@.*(\\s+\\*\\s{0,}[^"]*=\\s{0,}[^"]*,?){1,}.*\\)\\s+\\*\\s+\\*\\/#msU';
    /**
     * @see https://regex101.com/r/EA1xRY/6
     * @var string
     */
    public const VALID_ANNOTATION_VAR_RETURN_EXPLICIT_FORMAT_REGEX = '#\\*\\s+@(var|return)\\s+(\\(.*\\)|(".*")(\\|".*")|("?.*"?){1,})$#msU';
    /**
     * @see https://regex101.com/r/LprF44/8
     * @var string
     */
    public const INVALID_ANNOTATION_VAR_RETURN_EXPLICIT_FORMAT_REGEX = '#\\*\\s+@(var|return)([^\\s].*|\\s[^"\\s]*|([^"]*[^"]))$#msU';
    /**
     * @see https://regex101.com/r/uLmRxk/6
     * @var string
     */
    public const VALID_NO_DUPLICATE_COMMENT_REGEX = '#(?<c>(\\/\\/\\s{0,}.*\\s+){1,})#m';
    /**
     * @see https://regex101.com/r/Ef83BV/1
     * @var string
     */
    private const SPACE_REGEX = '#\\s#';
    /**
     * @see https://regex101.com/r/lC0i21/2
     * @var string
     */
    private const STAR_QUOTE_PARENTHESIS_REGEX = '#[\\*"\\(\\)]#';
    /**
     * @see https://regex101.com/r/j7agVx/1
     * @var string
     */
    private const ROUTE_VALID_REGEX = '#"\\s?:\\s?#';
    /**
     * @see https://regex101.com/r/qgp6Tr/1
     * @var string
     */
    private const ROUTE_INVALID_REGEX = '#"\\s?=\\s?#';
    /**
     * @var string
     * @see https://regex101.com/r/5DdLjE/1
     */
    private const ROUTE_LOCALIZATION_REPLACE_REGEX = '#[:=]#';
    /**
     * @see https://github.com/rectorphp/rector/issues/3388
     * @see https://github.com/rectorphp/rector/issues/3673
     * @see https://github.com/rectorphp/rector/issues/4274
     * @see https://github.com/rectorphp/rector/issues/4573
     * @see https://github.com/rectorphp/rector/issues/4581
     * @see https://github.com/rectorphp/rector/issues/4476
     * @see https://github.com/rectorphp/rector/issues/4620
     * @see https://github.com/rectorphp/rector/issues/4652
     * @see https://github.com/rectorphp/rector/issues/4691
     */
    public function rollbackValidAnnotation(string $originalContent, string $content, string $validAnnotationRegex, string $invalidAnnotationRegex) : string
    {
        $matchesValidAnnotation = \RectorPrefix20210119\Nette\Utils\Strings::matchAll($originalContent, $validAnnotationRegex);
        if ($matchesValidAnnotation === []) {
            return $content;
        }
        $matchesInValidAnnotation = \RectorPrefix20210119\Nette\Utils\Strings::matchAll($content, $invalidAnnotationRegex);
        if ($matchesInValidAnnotation === []) {
            return $content;
        }
        if (\count($matchesValidAnnotation) !== \count($matchesInValidAnnotation)) {
            return $content;
        }
        foreach ($matchesValidAnnotation as $key => $match) {
            $validAnnotation = $match[0];
            $invalidAnnotation = $matchesInValidAnnotation[$key][0];
            if ($this->isSkipped($validAnnotationRegex, $validAnnotation, $invalidAnnotation)) {
                continue;
            }
            $content = \str_replace($invalidAnnotation, $validAnnotation, $content);
        }
        return $content;
    }
    public function rollbackDuplicateComment(string $originalContent, string $content) : string
    {
        $matchNoDuplicateComments = \RectorPrefix20210119\Nette\Utils\Strings::matchAll($originalContent, self::VALID_NO_DUPLICATE_COMMENT_REGEX);
        if ($matchNoDuplicateComments === []) {
            return $content;
        }
        foreach ($matchNoDuplicateComments as $matchNoDuplicateComment) {
            $matchNoDuplicateComment['c'] = \trim($matchNoDuplicateComment['c']);
            $duplicatedComment = $matchNoDuplicateComment['c'] . \PHP_EOL . $matchNoDuplicateComment['c'];
            $content = \str_replace($duplicatedComment, $matchNoDuplicateComment['c'], $content);
        }
        return $content;
    }
    private function isSkipped(string $validAnnotationRegex, string $validAnnotation, string $invalidAnnotation) : bool
    {
        $validAnnotation = \RectorPrefix20210119\Nette\Utils\Strings::replace($validAnnotation, self::SPACE_REGEX, '');
        $invalidAnnotation = \RectorPrefix20210119\Nette\Utils\Strings::replace($invalidAnnotation, self::SPACE_REGEX, '');
        if ($validAnnotationRegex !== self::VALID_ANNOTATION_ROUTE_REGEX) {
            $validAnnotation = \RectorPrefix20210119\Nette\Utils\Strings::replace($validAnnotation, self::STAR_QUOTE_PARENTHESIS_REGEX, '');
            $invalidAnnotation = \RectorPrefix20210119\Nette\Utils\Strings::replace($invalidAnnotation, self::STAR_QUOTE_PARENTHESIS_REGEX, '');
            if ($validAnnotationRegex === self::VALID_ANNOTATION_ROUTE_LOCALIZATION_REGEX) {
                $validAnnotation = \RectorPrefix20210119\Nette\Utils\Strings::replace($validAnnotation, self::ROUTE_LOCALIZATION_REPLACE_REGEX, '');
                $invalidAnnotation = \RectorPrefix20210119\Nette\Utils\Strings::replace($invalidAnnotation, self::ROUTE_LOCALIZATION_REPLACE_REGEX, '');
            }
            return $validAnnotation !== $invalidAnnotation;
        }
        $validAnnotation = \RectorPrefix20210119\Nette\Utils\Strings::replace($validAnnotation, self::ROUTE_VALID_REGEX, '');
        $invalidAnnotation = \RectorPrefix20210119\Nette\Utils\Strings::replace($invalidAnnotation, self::ROUTE_INVALID_REGEX, '');
        return $validAnnotation !== $invalidAnnotation;
    }
}
