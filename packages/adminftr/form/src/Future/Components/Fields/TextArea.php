<?php

namespace Adminftr\Form\Future\Components\Fields;

use Adminftr\Form\Future\Components\Field;

class TextArea extends Field
{
    public function render()
    {
        return view('form::base.form.textarea', [
            'isRequired' => $this->isRequired,
            'classes' => $this->classes,
            'attributes' => $this->getAttributes(),
            'placeholder' => $this->placeholder,
            'label' => $this->label,
            'name' => $this->name,
            'canHide' => $this->canHide,
        ]);
    }
}
