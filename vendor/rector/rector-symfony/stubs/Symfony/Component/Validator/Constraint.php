<?php

declare (strict_types=1);
namespace RectorPrefix20210319\Symfony\Component\Validator;

if (\class_exists('RectorPrefix20210319\\Symfony\\Component\\Validator\\Constraint')) {
    return;
}
use Exception;
use RectorPrefix20210319\Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use RectorPrefix20210319\Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
/**
 * @property array $groups The groups that the constraint belongs to
 */
abstract class Constraint
{
    /**
     * The name of the group given to all constraints with no explicit group.
     */
    const DEFAULT_GROUP = 'Default';
    /**
     * Marks a constraint that can be put onto classes.
     */
    const CLASS_CONSTRAINT = 'class';
    /**
     * Marks a constraint that can be put onto properties.
     */
    const PROPERTY_CONSTRAINT = 'property';
    /**
     * Maps error codes to the names of their constants.
     */
    protected static $errorNames = [];
    /**
     * Domain-specific data attached to a constraint.
     *
     * @var mixed
     */
    public $payload;
    /**
     * Initializes the constraint with options.
     *
     * You should pass an associative array. The keys should be the names of
     * existing properties in this class. The values should be the value for these
     * properties.
     *
     * Alternatively you can override the method getDefaultOption() to return the
     * name of an existing property. If no associative array is passed, this
     * property is set instead.
     *
     * You can force that certain options are set by overriding
     * getRequiredOptions() to return the names of these options. If any
     * option is not set here, an exception is thrown.
     *
     * @param mixed $options The options (as associative array)
     *                       or the value for the default
     *                       option (any other type)
     *
     * @throws InvalidOptionsException       When you pass the names of non-existing
     *                                       options
     * @throws MissingOptionsException       When you don't pass any of the options
     *                                       returned by getRequiredOptions()
     * @throws Exception() When you don't pass an associative
     *                                       array, but getDefaultOption() returns
     *                                       null
     */
    public function __construct($options = null)
    {
        $defaultOption = $this->getDefaultOption();
        $invalidOptions = [];
        $missingOptions = \array_flip((array) $this->getRequiredOptions());
        $knownOptions = \get_object_vars($this);
        // The "groups" option is added to the object lazily
        $knownOptions['groups'] = \true;
        if (\is_array($options) && isset($options['value']) && !\property_exists($this, 'value')) {
            if (null === $defaultOption) {
                throw new \Exception(\sprintf('No default option is configured for constraint "%s".', \get_class($this)));
            }
            $options[$defaultOption] = $options['value'];
            unset($options['value']);
        }
        if (\is_array($options)) {
            \reset($options);
        }
        if ($options && \is_array($options) && \is_string(\key($options))) {
            foreach ($options as $option => $value) {
                if (\array_key_exists($option, $knownOptions)) {
                    $this->{$option} = $value;
                    unset($missingOptions[$option]);
                } else {
                    $invalidOptions[] = $option;
                }
            }
        } elseif (null !== $options && !(\is_array($options) && 0 === \count($options))) {
            if (null === $defaultOption) {
                throw new \Exception(\sprintf('No default option is configured for constraint "%s".', \get_class($this)));
            }
            if (\array_key_exists($defaultOption, $knownOptions)) {
                $this->{$defaultOption} = $options;
                unset($missingOptions[$defaultOption]);
            } else {
                $invalidOptions[] = $defaultOption;
            }
        }
        if (\count($invalidOptions) > 0) {
            throw new \RectorPrefix20210319\Symfony\Component\OptionsResolver\Exception\InvalidOptionsException(\sprintf('The options "%s" do not exist in constraint "%s".', \implode('", "', $invalidOptions), \get_class($this)), $invalidOptions);
        }
        if (\count($missingOptions) > 0) {
            throw new \RectorPrefix20210319\Symfony\Component\OptionsResolver\Exception\MissingOptionsException(\sprintf('The options "%s" must be set for constraint "%s".', \implode('", "', \array_keys($missingOptions)), \get_class($this)), \array_keys($missingOptions));
        }
    }
    /**
     * Sets the value of a lazily initialized option.
     *
     * Corresponding properties are added to the object on first access. Hence
     * this method will be called at most once per constraint instance and
     * option name.
     *
     * @param string $option The option name
     * @param mixed  $value  The value to set
     *
     * @throws InvalidOptionsException If an invalid option name is given
     */
    public function __set($option, $value)
    {
        if ('groups' === $option) {
            $this->groups = (array) $value;
            return;
        }
        throw new \RectorPrefix20210319\Symfony\Component\OptionsResolver\Exception\InvalidOptionsException(\sprintf('The option "%s" does not exist in constraint "%s".', $option, \get_class($this)), [$option]);
    }
    /**
     * Returns the value of a lazily initialized option.
     *
     * Corresponding properties are added to the object on first access. Hence
     * this method will be called at most once per constraint instance and
     * option name.
     *
     * @param string $option The option name
     *
     * @return mixed The value of the option
     *
     * @throws InvalidOptionsException If an invalid option name is given
     *
     * @internal this method should not be used or overwritten in userland code
     */
    public function __get($option)
    {
        if ('groups' === $option) {
            $this->groups = [self::DEFAULT_GROUP];
            return $this->groups;
        }
        throw new \RectorPrefix20210319\Symfony\Component\OptionsResolver\Exception\InvalidOptionsException(\sprintf('The option "%s" does not exist in constraint "%s".', $option, \get_class($this)), [$option]);
    }
    /**
     * @param string $option The option name
     *
     * @return bool
     */
    public function __isset($option)
    {
        return 'groups' === $option;
    }
    /**
     * Adds the given group if this constraint is in the Default group.
     *
     * @param string $group
     */
    public function addImplicitGroupName($group)
    {
        if (\in_array(self::DEFAULT_GROUP, $this->groups) && !\in_array($group, $this->groups)) {
            $this->groups[] = $group;
        }
    }
    /**
     * Returns the name of the default option.
     *
     * Override this method to define a default option.
     *
     * @return string|null
     *
     * @see __construct()
     */
    public function getDefaultOption()
    {
        return null;
    }
    /**
     * Returns the name of the required options.
     *
     * Override this method if you want to define required options.
     *
     * @return array
     *
     * @see __construct()
     */
    public function getRequiredOptions()
    {
        return [];
    }
    /**
     * Returns the name of the class that validates this constraint.
     *
     * By default, this is the fully qualified name of the constraint class
     * suffixed with "Validator". You can override this method to change that
     * behavior.
     *
     * @return string
     */
    public function validatedBy()
    {
        return \get_class($this) . 'Validator';
    }
    /**
     * Returns whether the constraint can be put onto classes, properties or
     * both.
     *
     * This method should return one or more of the constants
     * Constraint::CLASS_CONSTRAINT and Constraint::PROPERTY_CONSTRAINT.
     *
     * @return string|array One or more constant values
     */
    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }
    /**
     * Optimizes the serialized value to minimize storage space.
     *
     * @internal
     */
    public function __sleep() : array
    {
        // Initialize "groups" option if it is not set
        $this->groups;
        return \array_keys(\get_object_vars($this));
    }
}
