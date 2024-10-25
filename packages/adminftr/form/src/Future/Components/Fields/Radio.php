<?php

namespace Adminftr\Form\Future\Components\Fields;

use Adminftr\Form\Future\Components\Field;

class Radio extends Field
{
    public $options = [];

    public function options(array $options)
    {
        $this->options = $options;

        return $this;
    }

    public function label(string $label): Field
    {
        $this->label = $label;

        return $this;
    }

    public function render()
    {
        return view('form::base.form.radio', [
            'isRequired' => $this->isRequired,
            'classes' => $this->classes,
            'attributes' => $this->getAttributes(),
            'options' => $this->options,
            'defaultValue' => $this->defaultValue,
            'name' => $this->name,
            'label' => $this->label,
            'canHide' => $this->canHide,
            'reactive' => $this->reactive,
        ]);
    }
}
