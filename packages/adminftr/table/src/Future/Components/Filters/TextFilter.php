<?php

namespace Adminftr\Table\Future\Components\Filters;

/**
 * Class TextFilter
 *
 * Represents a text filter with a placeholder.
 */
class TextFilter extends Filter
{
    /**
     * Placeholder text for the input field.
     *
     * @var string
     */
    public string $placeholder = '';

    /**
     * Set the placeholder text for the text filter.
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
     * Render the view for the text filter.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $name = $this->name;
        $label = $this->label;
        $placeholder = $this->placeholder;

        return view('future::base.filters.text-filter', compact('name', 'label', 'placeholder'));
    }
}
