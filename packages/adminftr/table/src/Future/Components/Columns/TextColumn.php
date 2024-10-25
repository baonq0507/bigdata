<?php

namespace Adminftr\Table\Future\Components\Columns;

use Adminftr\Table\Future\Components\Column;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

/**
 * Class TextColumn
 *
 * Represents a column in a table that displays text with various customizable features.
 */
class TextColumn extends Column
{
    /**
     * The default value to display if no value is provided.
     *
     * @var mixed
     */
    public $default;

    /**
     * The number of words to display if the `words` method is used.
     *
     * @var int|null
     */
    public $words;


    public $icon;

    /**
     * Callback to determine the description HTML.
     *
     * @var callable|null
     */
    public $descriptionCallback;

    /**
     * Whether to display a copy button.
     *
     * @var bool
     */
    public $copy = false;

    /**
     * Tooltip information for the column.
     *
     * @var array|null
     */
    public $tooltip;

    /**
     * Whether the column is a relation.
     *
     * @var bool
     */
    public $isRelation = false;

    /**
     * Create a new instance of the TextColumn.
     *
     * @param string $name
     * @param string|null $label
     * @param bool $sortable
     * @return static
     */
    public static function make(string $name, ?string $label = null, bool $sortable = false)
    {
        return new static($name, $label, $sortable);
    }

    /**
     * Set the default value to display if no value is provided.
     *
     * @param mixed $value
     * @return $this
     */
    public function default($value)
    {
        $this->default = $value;

        return $this;
    }

    /**
     * Set the callback to determine the description HTML.
     *
     * @param callable $callback
     * @return $this
     */
    public function description(callable $callback)
    {
        $this->descriptionCallback = $callback;

        return $this;
    }

    /**
     * Hide the middle part of the text and display ellipsis.
     *
     * @param int $start Number of characters to keep at the start
     * @param int $end Number of characters to keep at the end
     * @return $this
     */
    public function hideMiddle($start = 3, $end = 3)
    {
        $this->renderCallback = function ($model, $value) use ($start, $end) {
            $length = strlen($value);
            if ($length > $start + $end) {
                $startString = substr($value, 0, $start);
                $endString = substr($value, $length - $end, $end);

                return $startString.'*****'.$endString;
            }

            return $value;
        };

        return $this;
    }

    /**
     * Display the text as a badge with a color and label.
     *
     * @param array $colorMap Array mapping values to badge colors
     * @param array $labelMap Array mapping values to badge labels
     * @return $this
     */
    public function badge(array $colorMap, array $labelMap = [])
    {
        $this->renderCallback = function ($model, $value) use ($colorMap, $labelMap) {
            $color = $colorMap[$value] ?? 'secondary'; // Default to 'secondary' if no match
            $label = $labelMap[$value] ?? $value; // Default to value if no match

            return "<span class='badge text-white bg-{$color}'>{$label}</span>";
        };

        return $this;
    }

    /**
     * Set a custom HTML rendering callback.
     *
     * @param callable $callback
     * @return $this
     */
    public function renderHtml(callable $callback)
    {
        $this->renderCallback = $callback;

        return $this;
    }

    /**
     * Indicate that this column is a relation.
     *
     * @return $this
     */
    public function isRelation()
    {
        $this->isRelation = true;

        return $this;
    }

    /**
     * Display a copy button for the text.
     *
     * @return $this
     */
    public function copy()
    {
        $this->copy = true;

        return $this;
    }

    /**
     * Set the callback to determine the icon HTML.
     *
     * @param string|callable $callback
     * @return $this
     */
    public function icon(string|callable $callback)
    {
        $this->icon = $callback;

        return $this;
    }

    /**
     * Set the font weight CSS class for the text.
     *
     * @param string $class
     * @return $this
     */
    public function fontWeight(string $class)
    {
        $this->fontWeightClass = $class;

        return $this;
    }

    /**
     * Set the number of words to display.
     *
     * @param int $words
     * @return $this
     */
    public function words($words = 10)
    {
        $this->words = $words;

        return $this;
    }

    /**
     * Set the tooltip for the text.
     *
     * @param string|null $tooltip
     * @param string $placement
     * @return $this
     */
    public function tooltip($tooltip = null, $placement = 'top')
    {
        $this->tooltip = [
            'tooltip' => $tooltip,
            'placement' => $placement,
        ];

        return $this;
    }

    /**
     * Render the text column for the given model.
     *
     * @param Model $model
     * @return \Illuminate\View\View
     */
    public function render(Model $model)
    {
        $path = explode('.', $this->name);
        $value = count($path) > 1 ? data_get($model, $this->name) : $model->{$this->name};

        if ($value instanceof Collection) {
            $value = $value->pluck('name')->join(', ');
        }

        $iconHtml = '';
        $descriptionHtml = '';
        $iconCopy = '';

        if ($this->words) {
            $value = implode(' ', array_slice(explode(' ', $value), 0, $this->words));
        }

        if ($this->icon instanceof \Closure) {
            $iconHtml = call_user_func($this->icon, $model);
        } elseif ($this->icon) {
            $iconHtml = new HtmlString("<i class='{$this->icon}'></i>");
        }

        if ($this->descriptionCallback) {
            $descriptionHtml = call_user_func($this->descriptionCallback, $model);
        }

        if ($this->copy) {
            $iconCopy = new HtmlString("
                <button class='btn btn-sm btn-icon btn-soft-primary btn-copy' data-clipboard-text='{$value}'
                data-bs-toggle='tooltip' data-bs-placement='top' title='Copy'>
                    <i class='far fa-copy'></i>
                </button>
            ");
        }

        $renderedValue = new HtmlString($this->renderCallback ?
            call_user_func($this->renderCallback, $model, $value) : $value);

        return view('future::base.table.column', [
            'value' => $renderedValue,
            'iconHtml' => $iconHtml,
            'iconCopy' => $iconCopy,
            'tooltip' => $this->tooltip,
            'fontWeightClass' => $this->fontWeightClass,
            'descriptionHtml' => $descriptionHtml,
        ]);
    }
}
