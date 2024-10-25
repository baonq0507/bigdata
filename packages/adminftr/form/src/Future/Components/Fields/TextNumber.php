<?php

namespace Adminftr\Form\Future\Components\Fields;

use Adminftr\Form\Future\Components\Field;

class TextNumber extends Field
{
    public $min = null;

    public $max = null;

    public $step = null;

    public function min(int $min)
    {
        $this->min = $min;

        return $this;
    }

    public function max(int $max)
    {
        $this->max = $max;

        return $this;
    }

    public function step(int $step)
    {
        $this->step = $step;

        return $this;
    }

    public function render()
    {
        $reactive = $this->reactive;
        $wireModelDirective = $reactive ? 'wire:model.live.debounce.500ms' : 'wire:model';
        return view('form::base.form.textnumber', [
            'isRequired' => $this->isRequired,
            'classes' => $this->classes,
            'attributes' => $this->getAttributes(),
            'min' => $this->min,
            'max' => $this->max,
            'step' => $this->step,
            'placeholder' => $this->placeholder,
            'label' => $this->label,
            'name' => $this->name,
            'canHide' => $this->canHide,
            'wireModelDirective' => $wireModelDirective,
        ]);
    }
}
