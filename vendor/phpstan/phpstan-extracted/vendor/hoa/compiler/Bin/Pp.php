<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2017, Hoa community. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */
namespace _PhpScoperb75b35f52b74\Hoa\Compiler\Bin;

use _PhpScoperb75b35f52b74\Hoa\Compiler;
use _PhpScoperb75b35f52b74\Hoa\Consistency;
use _PhpScoperb75b35f52b74\Hoa\Console;
use _PhpScoperb75b35f52b74\Hoa\File;
/**
 * Class Hoa\Compiler\Bin\Pp.
 *
 * Play with PP.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Pp extends \_PhpScoperb75b35f52b74\Hoa\Console\Dispatcher\Kit
{
    /**
     * Options description.
     *
     * @var array
     */
    protected $options = [['visitor', \_PhpScoperb75b35f52b74\Hoa\Console\GetOption::REQUIRED_ARGUMENT, 'v'], ['visitor-class', \_PhpScoperb75b35f52b74\Hoa\Console\GetOption::REQUIRED_ARGUMENT, 'c'], ['token-sequence', \_PhpScoperb75b35f52b74\Hoa\Console\GetOption::NO_ARGUMENT, 's'], ['trace', \_PhpScoperb75b35f52b74\Hoa\Console\GetOption::NO_ARGUMENT, 't'], ['help', \_PhpScoperb75b35f52b74\Hoa\Console\GetOption::NO_ARGUMENT, 'h'], ['help', \_PhpScoperb75b35f52b74\Hoa\Console\GetOption::NO_ARGUMENT, '?']];
    /**
     * The entry method.
     *
     * @return  int
     */
    public function main()
    {
        $visitor = null;
        $tokenSequence = \false;
        $trace = \false;
        while (\false !== ($c = $this->getOption($v))) {
            switch ($c) {
                case 'v':
                    switch (\strtolower($v)) {
                        case 'dump':
                            $visitor = '_PhpScoperb75b35f52b74\\Hoa\\Compiler\\Visitor\\Dump';
                            break;
                        default:
                            return $this->usage();
                    }
                    break;
                case 'c':
                    $visitor = \str_replace('.', '\\', $v);
                    break;
                case 's':
                    $tokenSequence = \true;
                    break;
                case 't':
                    $trace = \true;
                    break;
                case '__ambiguous':
                    $this->resolveOptionAmbiguity($v);
                    break;
                case 'h':
                case '?':
                default:
                    return $this->usage();
            }
        }
        $this->parser->listInputs($grammar, $language);
        if (empty($grammar) || empty($language) && '0' !== $language) {
            return $this->usage();
        }
        $compiler = \_PhpScoperb75b35f52b74\Hoa\Compiler\Llk::load(new \_PhpScoperb75b35f52b74\Hoa\File\Read($grammar));
        $stream = new \_PhpScoperb75b35f52b74\Hoa\File\Read($language);
        $data = $stream->readAll();
        try {
            $ast = $compiler->parse($data);
        } catch (\_PhpScoperb75b35f52b74\Hoa\Compiler\Exception $e) {
            if (\true === $tokenSequence) {
                $this->printTokenSequence($compiler, $data);
                echo "\n\n";
            }
            throw $e;
            return 1;
        }
        if (\true === $tokenSequence) {
            $this->printTokenSequence($compiler, $data);
            echo "\n\n";
        }
        if (\true === $trace) {
            $this->printTrace($compiler);
            echo "\n\n";
        }
        if (null !== $visitor) {
            $visitor = \_PhpScoperb75b35f52b74\Hoa\Consistency\Autoloader::dnew($visitor);
            echo $visitor->visit($ast);
        }
        return;
    }
    /**
     * Print trace.
     *
     * @param   \Hoa\Compiler\Llk\Parser  $compiler    Compiler.
     * @return  void
     */
    protected function printTrace(\_PhpScoperb75b35f52b74\Hoa\Compiler\Llk\Parser $compiler)
    {
        $i = 0;
        foreach ($compiler->getTrace() as $element) {
            if ($element instanceof \_PhpScoperb75b35f52b74\Hoa\Compiler\Llk\Rule\Entry) {
                $ruleName = $element->getRule();
                $rule = $compiler->getRule($ruleName);
                echo \str_repeat('>  ', ++$i), 'enter ', $ruleName;
                if (null !== ($id = $rule->getNodeId())) {
                    echo ' (', $id, ')';
                }
                echo "\n";
            } elseif ($element instanceof \_PhpScoperb75b35f52b74\Hoa\Compiler\Llk\Rule\Token) {
                echo \str_repeat('   ', $i + 1), 'token ', $element->getTokenName(), ', consumed ', $element->getValue(), "\n";
            } else {
                echo \str_repeat('<  ', $i--), 'ekzit ', $element->getRule(), "\n";
            }
        }
        return;
    }
    /**
     * Print token sequence.
     *
     * @param   \Hoa\Compiler\Llk\Parser  $compiler    Compiler.
     * @param   string                    $data        Data to lex.
     * @return  void
     */
    protected function printTokenSequence(\_PhpScoperb75b35f52b74\Hoa\Compiler\Llk\Parser $compiler, $data)
    {
        $lexer = new \_PhpScoperb75b35f52b74\Hoa\Compiler\Llk\Lexer();
        $sequence = $lexer->lexMe($data, $compiler->getTokens());
        $format = '%' . (\strlen((string) \count($sequence)) + 1) . 's  ' . '%-13s %-20s  %s  %6s' . "\n";
        $header = \sprintf($format, '#', 'namespace', 'token name', 'token value                   ', 'offset');
        echo $header, \str_repeat('-', \strlen($header)), "\n";
        foreach ($sequence as $i => $token) {
            \printf($format, $i, $token['namespace'], $token['token'], 30 < $token['length'] ? \mb_substr($token['value'], 0, 29) . '…' : 'EOF' === $token['token'] ? \str_repeat(' ', 30) : $token['value'] . \str_repeat(' ', 30 - $token['length']), $token['offset']);
        }
        return;
    }
    /**
     * The command usage.
     *
     * @return  int
     */
    public function usage()
    {
        echo 'Usage   : compiler:pp <options> [grammar.pp] [language]', "\n", 'Options :', "\n", $this->makeUsageOptionsList(['v' => 'Visitor name (only “dump” is supported).', 'c' => 'Visitor classname (using . instead of \\ works).', 's' => 'Print token sequence.', 't' => 'Print trace.', 'help' => 'This help.']), "\n";
        return;
    }
}
__halt_compiler();
Compile and visit languages with grammars.

