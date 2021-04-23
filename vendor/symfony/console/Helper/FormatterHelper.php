<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210423\Symfony\Component\Console\Helper;

use RectorPrefix20210423\Symfony\Component\Console\Formatter\OutputFormatter;
/**
 * The Formatter class provides helpers to format messages.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class FormatterHelper extends \RectorPrefix20210423\Symfony\Component\Console\Helper\Helper
{
    /**
     * Formats a message within a section.
     *
     * @return string The format section
     */
    public function formatSection(string $section, string $message, string $style = 'info')
    {
        return \sprintf('<%s>[%s]</%s> %s', $style, $section, $style, $message);
    }
    /**
     * Formats a message as a block of text.
     *
     * @param string|array $messages The message to write in the block
     *
     * @return string The formatter message
     */
    public function formatBlock($messages, string $style, bool $large = \false)
    {
        if (!\is_array($messages)) {
            $messages = [$messages];
        }
        $len = 0;
        $lines = [];
        foreach ($messages as $message) {
            $message = \RectorPrefix20210423\Symfony\Component\Console\Formatter\OutputFormatter::escape($message);
            $lines[] = \sprintf($large ? '  %s  ' : ' %s ', $message);
            $len = \max(self::strlen($message) + ($large ? 4 : 2), $len);
        }
        $messages = $large ? [\str_repeat(' ', $len)] : [];
        for ($i = 0; isset($lines[$i]); ++$i) {
            $messages[] = $lines[$i] . \str_repeat(' ', $len - self::strlen($lines[$i]));
        }
        if ($large) {
            $messages[] = \str_repeat(' ', $len);
        }
        for ($i = 0; isset($messages[$i]); ++$i) {
            $messages[$i] = \sprintf('<%s>%s</%s>', $style, $messages[$i], $style);
        }
        return \implode("\n", $messages);
    }
    /**
     * Truncates a message to the given length.
     *
     * @return string
     */
    public function truncate(string $message, int $length, string $suffix = '...')
    {
        $computedLength = $length - self::strlen($suffix);
        if ($computedLength > self::strlen($message)) {
            return $message;
        }
        return self::substr($message, 0, $length) . $suffix;
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'formatter';
    }
}
