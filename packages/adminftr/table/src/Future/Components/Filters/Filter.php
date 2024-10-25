<?php

namespace Adminftr\Table\Future\Components\Filters;

/**
 * Class Filter
 *
 * Represents a basic filter used in table components. This class provides
 * the common properties and methods that can be used by various specific
 * filter types.
 */
class Filter
{
    /**
     * The name of the filter.
     *
     * @var string|null
     */
    protected ?string $name;

    /**
     * The label for the filter.
     *
     * @var string|null
     */
    protected ?string $label;

    /**
     * The operator to be used for the filter comparison.
     *
     * @var string|null
     */
    protected ?string $operator;

    /**
     * Create a new instance of the Filter.
     *
     * @param string $name The name of the filter.
     * @param string $label The label for the filter.
     * @param string $operator The operator for comparison (default is '=').
     */
    public function __construct(string $name, string $label, string $operator = '=')
    {
        $this->name = $name;
        $this->label = $label;
        $this->operator = $operator;
    }

    /**
     * Create a new instance of the Filter using the provided parameters.
     *
     * @param string $name The name of the filter.
     * @param string $label The label for the filter.
     * @param string $operator The operator for comparison (default is '=').
     * @return self
     */
    public static function make(string $name, string $label, string $operator = '='): self
    {
        return new static($name, $label, $operator);
    }

    /**
     * Get the name of the filter.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the label for the filter.
     *
     * @return string|null
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get the operator used for comparison in the filter.
     *
     * @return string|null
     */
    public function getOperator()
    {
        return $this->operator;
    }
}
