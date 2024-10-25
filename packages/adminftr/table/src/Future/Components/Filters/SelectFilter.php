<?php

namespace Adminftr\Table\Future\Components\Filters;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SelectFilter
 *
 * Represents a filter for selecting options from a dropdown or multiple options.
 */
class SelectFilter extends Filter
{
    /**
     * Options for the select filter.
     *
     * @var array
     */
    public array $options = [];

    /**
     * Indicates if multiple selections are allowed.
     *
     * @var bool
     */
    public bool $multiple = false;

    /**
     * Field name for the option value.
     *
     * @var string
     */
    public string $valueField = 'id';

    /**
     * Field name for the option label.
     *
     * @var string
     */
    public string $labelField = 'name';

    /**
     * Plugins to be used with the select filter.
     *
     * @var array
     */
    public array $plugins = ['input_autogrow', 'remove_button', 'caret_position'];

    /**
     * Maximum number of options to display.
     *
     * @var int
     */
    public int $maxOptions = 10;

    /**
     * Indicates if live search is enabled.
     *
     * @var bool
     */
    public bool $liveSearch = false;

    /**
     * Field name used for live search.
     *
     * @var string
     */
    public string $keySearch = 'name';

    /**
     * Limit for the number of search results.
     *
     * @var int
     */
    protected int $limit = 10;

    /**
     * Model to be used for dynamic options.
     *
     * @var Model
     */
    protected Model $model;

    /**
     * Callback for live search functionality.
     *
     * @var callable|null
     */
    protected $callbackSearch;

    /**
     * Set options for the select filter.
     *
     * @param mixed $options
     * @return $this
     */
    public function options($options)
    {
        if (is_callable($options)) {
            $this->options = call_user_func($options);
        } else {
            $this->options = $options;
        }

        return $this;
    }

    /**
     * Set plugins to be used with the select filter.
     *
     * @param array $plugins
     * @return $this
     */
    public function plugins($plugins)
    {
        $this->plugins = $plugins;

        return $this;
    }

    /**
     * Set the maximum number of options to display.
     *
     * @param int $maxOptions
     * @return $this
     */
    public function maxOptions(int $maxOptions)
    {
        $this->maxOptions = $maxOptions;

        return $this;
    }

    /**
     * Set the field name for the option value.
     *
     * @param string $valueField
     * @return $this
     */
    public function valueField(string $valueField)
    {
        $this->valueField = $valueField;

        return $this;
    }

    /**
     * Set the model to be used for dynamic options and its fields.
     *
     * @param Model $model
     * @param string $valueField
     * @param string $labelField
     * @return $this
     */
    public function model(Model $model, string $valueField = 'id', string $labelField = 'name')
    {
        $this->model = $model;
        $this->valueField = $valueField;
        $this->labelField = $labelField;

        return $this;
    }

    /**
     * Enable live search and set the callback for dynamic options.
     *
     * @param callable|null $callback
     * @return $this
     */
    public function liveSearch(?callable $callback = null)
    {
        $this->liveSearch = true;
        if ($callback) {
            $this->callbackSearch = $callback;
            $this->options = call_user_func($callback, '')->toArray();
        }

        return $this;
    }

    /**
     * Search for options based on the provided value and update the options list.
     *
     * @param mixed $value
     * @return $this
     */
    public function search($value)
    {
        if ($this->callbackSearch) {
            $this->options = call_user_func($this->callbackSearch, $value)->map(function ($model) {
                return [
                    $this->valueField => $model->id,
                    $this->labelField => $model->name,
                ];
            })->toArray();

            return $this;
        }
        return $this;
    }

    /**
     * Set the limit for the number of search results.
     *
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Set the field name for live search key.
     *
     * @param string $keySearch
     * @return $this
     */
    public function keySearch(string $keySearch)
    {
        $this->keySearch = $keySearch;

        return $this;
    }

    /**
     * Set whether multiple selections are allowed.
     *
     * @param bool $multiple
     * @return $this
     */
    public function multiple(bool $multiple = true)
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * Render the select filter view.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        $name = $this->name;
        $label = $this->label;
        $options = $this->options;

        return view('future::base.filters.select-filter', [
            'name' => $name,
            'label' => $label,
            'options' => $options,
            'maxOptions' => $this->maxOptions,
            'multiple' => $this->multiple,
            'valueField' => $this->valueField,
            'labelField' => $this->labelField,
            'liveSearch' => $this->liveSearch,
            'keySearch' => $this->keySearch,
            'plugins' => $this->plugins,
        ]);
    }
}
