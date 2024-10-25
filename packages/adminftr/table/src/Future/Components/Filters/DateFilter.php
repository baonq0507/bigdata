<?php

namespace Adminftr\Table\Future\Components\Filters;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Class DateFilter
 *
 * Represents a filter for date fields in a table.
 */
class DateFilter extends Filter
{
    /**
     * Placeholder text for the date input field.
     *
     * @var string
     */
    public string $placeholder = '';

    /**
     * Set the placeholder text for the date input field.
     *
     * @param string $placeholder
     * @return $this
     */
    public function placeholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Render the date filter view.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        $name = $this->name;
        $label = $this->label;
        $placeholder = $this->placeholder;

        return view('future::base.filters.date-filter', compact('name', 'label', 'placeholder'));
    }
}
