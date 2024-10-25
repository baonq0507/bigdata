<?php

namespace Adminftr\Table\Future\Components\Columns;

use Adminftr\Table\Future\Components\Column;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IconColumn
 *
 * Represents a column in a table that displays icons with customizable attributes.
 */
class IconColumn extends Column
{
    /**
     * Callback to determine the icon to be displayed.
     *
     * @var callable|null
     */
    public $iconCallback;

    /**
     * Callback to determine the color of the icon.
     *
     * @var callable|null
     */
    public $colorCallback;

    /**
     * Callback to determine the size of the icon.
     *
     * @var callable|null
     */
    public $sizeCallback;

    /**
     * Callback to determine the tooltip for the icon.
     *
     * @var callable|null
     */
    public $tooltipCallback;

    /**
     * Callback to determine the CSS class for the icon.
     *
     * @var callable|null
     */
    public $classCallback;

    /**
     * Callback to determine whether the icon should be aria-hidden.
     *
     * @var callable|null
     */
    public $ariaHiddenCallback;

    /**
     * Callback to determine the role of the icon.
     *
     * @var callable|null
     */
    public $roleCallback;

    /**
     * Create a new instance of the IconColumn.
     *
     * @param string $name
     * @param string|null $label
     * @return static
     */
    public static function make(string $name, ?string $label = null)
    {
        return new static($name, $label);
    }

    /**
     * Set the callback to determine the icon to be displayed.
     *
     * @param callable $callback
     * @return $this
     */
    public function icon(callable $callback)
    {
        $this->iconCallback = $callback;

        return $this;
    }

    /**
     * Set the callback to determine the color of the icon.
     *
     * @param callable $callback
     * @return $this
     */
    public function color(callable $callback)
    {
        $this->colorCallback = $callback;

        return $this;
    }

    /**
     * Set the callback to determine the size of the icon.
     *
     * @param callable $callback
     * @return $this
     */
    public function size(callable $callback)
    {
        $this->sizeCallback = $callback;

        return $this;
    }

    /**
     * Set the callback to determine the tooltip for the icon.
     *
     * @param callable $callback
     * @return $this
     */
    public function tooltip(callable $callback)
    {
        $this->tooltipCallback = $callback;

        return $this;
    }

    /**
     * Set the callback to determine the CSS class for the icon.
     *
     * @param callable $callback
     * @return $this
     */
    public function class(callable $callback)
    {
        $this->classCallback = $callback;

        return $this;
    }

    /**
     * Set the callback to determine whether the icon should be aria-hidden.
     *
     * @param callable $callback
     * @return $this
     */
    public function ariaHidden(callable $callback)
    {
        $this->ariaHiddenCallback = $callback;

        return $this;
    }

    /**
     * Set the callback to determine the role of the icon.
     *
     * @param callable $callback
     * @return $this
     */
    public function role(callable $callback)
    {
        $this->roleCallback = $callback;

        return $this;
    }

    /**
     * Render the icon HTML for the given model.
     *
     * @param Model $model
     * @return \Illuminate\View\View
     */
    public function render(Model $model)
    {
        // Use the provided callbacks to determine the icon attributes.
        $icon = call_user_func($this->iconCallback, $model);
        $color = call_user_func($this->colorCallback, $model);
        $size = $this->sizeCallback ? call_user_func($this->sizeCallback, $model) : '1em';
        $tooltip = $this->tooltipCallback ? call_user_func($this->tooltipCallback, $model) : '';
        $class = $this->classCallback ? call_user_func($this->classCallback, $model) : '';
        $ariaHidden = $this->ariaHiddenCallback ? call_user_func($this->ariaHiddenCallback, $model) : 'true';
        $role = $this->roleCallback ? call_user_func($this->roleCallback, $model) : 'presentation';

        // Return the view with the icon attributes.
        return view('future::base.table.icon', compact('icon', 'color', 'size', 'tooltip', 'class', 'ariaHidden', 'role'));
    }
}
