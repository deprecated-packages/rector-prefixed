<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210317\Symfony\Component\ErrorHandler\Exception;

/**
 * Data Object that represents a Silenced Error.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class SilencedErrorContext implements \JsonSerializable
{
    public $count = 1;
    private $severity;
    private $file;
    private $line;
    private $trace;
    /**
     * @param int $severity
     * @param string $file
     * @param int $line
     * @param mixed[] $trace
     * @param int $count
     */
    public function __construct($severity, $file, $line, $trace = [], $count = 1)
    {
        $this->severity = $severity;
        $this->file = $file;
        $this->line = $line;
        $this->trace = $trace;
        $this->count = $count;
    }
    public function getSeverity() : int
    {
        return $this->severity;
    }
    public function getFile() : string
    {
        return $this->file;
    }
    public function getLine() : int
    {
        return $this->line;
    }
    public function getTrace() : array
    {
        return $this->trace;
    }
    public function jsonSerialize() : array
    {
        return ['severity' => $this->severity, 'file' => $this->file, 'line' => $this->line, 'trace' => $this->trace, 'count' => $this->count];
    }
}
