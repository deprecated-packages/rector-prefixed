<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel\DataCollector;

use _PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Caster\CutStub;
use _PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Caster\ReflectionCaster;
use _PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Cloner\ClonerInterface;
use _PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Cloner\Data;
use _PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Cloner\Stub;
use _PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Cloner\VarCloner;
/**
 * DataCollector.
 *
 * Children of this class must store the collected data in the data property.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Bernhard Schussek <bschussek@symfony.com>
 */
abstract class DataCollector implements \_PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface
{
    /**
     * @var array|Data
     */
    protected $data = [];
    /**
     * @var ClonerInterface
     */
    private $cloner;
    /**
     * @deprecated since Symfony 4.3, store all the serialized state in the data property instead
     */
    public function serialize()
    {
        @\trigger_error(\sprintf('The "%s" method is deprecated since Symfony 4.3, store all the serialized state in the data property instead.', __METHOD__), \E_USER_DEPRECATED);
        $trace = \debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
        $isCalledFromOverridingMethod = isset($trace[1]['function'], $trace[1]['object']) && 'serialize' === $trace[1]['function'] && $this === $trace[1]['object'];
        return $isCalledFromOverridingMethod ? $this->data : \serialize($this->data);
    }
    /**
     * @deprecated since Symfony 4.3, store all the serialized state in the data property instead
     */
    public function unserialize($data)
    {
        @\trigger_error(\sprintf('The "%s" method is deprecated since Symfony 4.3, store all the serialized state in the data property instead.', __METHOD__), \E_USER_DEPRECATED);
        $this->data = \is_array($data) ? $data : \unserialize($data);
    }
    /**
     * Converts the variable into a serializable Data instance.
     *
     * This array can be displayed in the template using
     * the VarDumper component.
     *
     * @param mixed $var
     *
     * @return Data
     */
    protected function cloneVar($var)
    {
        if ($var instanceof \_PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Cloner\Data) {
            return $var;
        }
        if (null === $this->cloner) {
            $this->cloner = new \_PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Cloner\VarCloner();
            $this->cloner->setMaxItems(-1);
            $this->cloner->addCasters($this->getCasters());
        }
        return $this->cloner->cloneVar($var);
    }
    /**
     * @return callable[] The casters to add to the cloner
     */
    protected function getCasters()
    {
        $casters = ['*' => function ($v, array $a, \_PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Cloner\Stub $s, $isNested) {
            if (!$v instanceof \_PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Cloner\Stub) {
                foreach ($a as $k => $v) {
                    if (\is_object($v) && !$v instanceof \DateTimeInterface && !$v instanceof \_PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Cloner\Stub) {
                        $a[$k] = new \_PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Caster\CutStub($v);
                    }
                }
            }
            return $a;
        }] + \_PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Caster\ReflectionCaster::UNSET_CLOSURE_FILE_INFO;
        return $casters;
    }
    /**
     * @return array
     */
    public function __sleep()
    {
        if (__CLASS__ !== ($c = (new \ReflectionMethod($this, 'serialize'))->getDeclaringClass()->name)) {
            @\trigger_error(\sprintf('Implementing the "%s::serialize()" method is deprecated since Symfony 4.3, store all the serialized state in the "data" property instead.', $c), \E_USER_DEPRECATED);
            $this->data = $this->serialize();
        }
        return ['data'];
    }
    public function __wakeup()
    {
        if (__CLASS__ !== ($c = (new \ReflectionMethod($this, 'unserialize'))->getDeclaringClass()->name)) {
            @\trigger_error(\sprintf('Implementing the "%s::unserialize()" method is deprecated since Symfony 4.3, store all the serialized state in the "data" property instead.', $c), \E_USER_DEPRECATED);
            $this->unserialize($this->data);
        }
    }
}
