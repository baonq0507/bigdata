<?php

namespace Adminftr\Form\Future\Components\Fields;

use Adminftr\Form\Future\Components\Field;

class Toggle extends Field
{
    public bool $disabled = false;

    public function render()
    {
        $wireModelDirective = $this->reactive ? 'wire:model.live.debounce.500ms' : 'wire:model';

        return view('form::base.form.toggle', [
            'isRequired' => $this->isRequired,
            'classes' => $this->classes,
            'attributes' => $this->getAttributes(),
            'defaultValue' => $this->defaultValue,
            'name' => $this->name,
            'label' => $this->label,
            'canHide' => $this->canHide,
            'reactive' => $this->reactive,
            'required' => $this->isRequired ? 'required' : '',
            'wireModelDirective' => $wireModelDirective,
            'disabled' => $this->disabled,
        ]);
    }
}
