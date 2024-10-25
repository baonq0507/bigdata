<?php

namespace Adminftr\Form\Future\Components\Fields;

use Adminftr\Form\Future\Components\Field;
use Illuminate\Support\Facades\View;

class DateInput extends Field
{
    public string $format = 'Y-m-d H:i';

    public function label(string $label): Field
    {
        $this->label = $label;

        return $this;
    }

    public function defaultValue($value): Field
    {
        $this->defaultValue = date('d-m-Y H:i', strtotime($value));

        return $this;
    }

    public function format(string $format = 'd-m-Y H:i'): Field
    {
        $this->format = $format;

        return $this;
    }

    public function render()
    {
        return View::make('form::base.form.dateinput', [
            'name' => $this->name,
            'isRequired' => $this->isRequired,
            'classes' => $this->classes,
            'attributes' => $this->getAttributes(),
            'placeholder' => $this->placeholder,
            'label' => $this->label,
            'canHide' => $this->canHide,
            'format' => $this->format,
            'defaultValue' => $this->defaultValue,
            'reactive' => $this->reactive,
        ])->render();
    }
}
