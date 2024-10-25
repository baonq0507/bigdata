<?php

namespace Adminftr\Table\Future\Components;

use Illuminate\Support\HtmlString;

/**
 * Class Column
 *
 * Represents a column in a table with various formatting and rendering options.
 */
class Column
{
    /**
     * Column name (field).
     *
     * @var string
     */
    public string $name;

    /**
     * Column label.
     *
     * @var string
     */
    public string $label;

    /**
     * Indicates if the column is sortable.
     *
     * @var bool
     */
    public bool $sortable;

    /**
     * Indicates if the column is searchable.
     *
     * @var bool
     */
    public bool $searchable;

    /**
     * Indicates if the column is visible.
     *
     * @var bool
     */
    public bool $visible;

    /**
     * CSS class for font weight.
     *
     * @var string
     */
    public string $fontWeightClass = '';

    /**
     * Optional callback for rendering column values.
     *
     * @var callable|null
     */
    public $renderCallback;

    /**
     * Column width.
     *
     * @var string|null
     */
    public ?string $width = null;

    /**
     * Column text alignment.
     *
     * @var string|null
     */
    public ?string $textAlign;

    /**
     * Column height.
     *
     * @var string|null
     */
    public ?string $height = null;

    /**
     * Constructor to initialize the column.
     *
     * @param string $name
     * @param string|null $label
     * @param bool $sortable
     * @param bool $searchable
     * @param bool $visible
     * @param callable|null $renderCallback
     */
    public function __construct(string $name, ?string $label = null, bool $sortable = false, bool $searchable = false,
                                bool $visible = true, ?callable $renderCallback = null)
    {
        $this->name = $name;
        $this->label = $label ?? $name;
        $this->sortable = $sortable;
        $this->searchable = $searchable;
        $this->visible = $visible;
        $this->renderCallback = $renderCallback;
    }

    /**
     * Make the column sortable.
     *
     * @return $this
     */
    public function sortable()
    {
        $this->sortable = true;

        return $this;
    }

    /**
     * Make the column searchable.
     *
     * @return $this
     */
    public function searchable()
    {
        $this->searchable = true;

        return $this;
    }

    /**
     * Hide the column.
     *
     * @return $this
     */
    public function hide()
    {
        $this->visible = false;

        return $this;
    }

    /**
     * Render the column value as a clickable link.
     *
     * @param callable $urlCallback
     * @return $this
     */
    public function renderLink(callable $urlCallback)
    {
        $this->renderCallback = function ($model) use ($urlCallback) {
            $url = call_user_func($urlCallback, $model);

            return new HtmlString("<a href='{$url}'>{$model->{$this->name}}</a>");
        };

        return $this;
    }

    /**
     * Format the column value as a date/time.
     *
     * @param string $format
     * @return $this
     */
    public function dateTime($format = 'Y-m-d')
    {
        $this->renderCallback = function ($model, $value) use ($format) {
            return (new \DateTime($value))->format($format);
        };

        return $this;
    }

    /**
     * Show the time elapsed since the given date.
     *
     * @return $this
     */
    public function since()
    {
        $this->renderCallback = function ($model, $value) {
            $date = new \DateTime($value);
            $now = new \DateTime();
            $interval = $now->diff($date);

            return $interval->format('%y years, %m months, %d days');
        };

        return $this;
    }

    /**
     * Format the column value as a numeric value.
     *
     * @param int $decimalPlaces
     * @param string $decimalSeparator
     * @param string $thousandsSeparator
     * @return $this
     */
    public function numeric($decimalPlaces = 0, $decimalSeparator = '.', $thousandsSeparator = ',')
    {
        $this->renderCallback = function ($value) use ($decimalPlaces, $decimalSeparator, $thousandsSeparator) {
            return number_format($value, $decimalPlaces, $decimalSeparator, $thousandsSeparator);
        };

        return $this;
    }

    /**
     * Format the column value as a monetary value.
     *
     * @param string $currencySymbol
     * @return $this
     */
    public function money($currencySymbol)
    {
        $this->renderCallback = function ($value) use ($currencySymbol) {
            return $currencySymbol.' '.number_format($value, 2);
        };

        return $this;
    }

    /**
     * Set the height of the column.
     *
     * @param string $height
     * @return $this
     */
    public function height($height = '100px')
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Set the width of the column.
     *
     * @param string $width
     * @return $this
     */
    public function width($width = '100px')
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Set the text alignment of the column.
     *
     * @param string $textAlign
     * @return $this
     */
    public function textAlign($textAlign = 'left')
    {
        $this->textAlign = $textAlign;

        return $this;
    }
}
