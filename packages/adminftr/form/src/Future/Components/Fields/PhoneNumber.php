<?php

namespace Adminftr\Form\Future\Components\Fields;

use Adminftr\Form\Future\Components\Field;

class PhoneNumber extends Field
{
    public $maxLength = 10;

    public $pattern = '/^[0-9]*$/';

    public function maxLength(int $maxLength)
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    public function pattern(string $pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    public function label(string $label): Field
    {
        $this->label = $label;

        return $this;
    }

    public function render()
    {
        $required = $this->isRequired ? 'required' : '';
        $classes = ! empty($this->classes) ? 'class="form-control  '.$this->classes.'"' : 'class="form-control "';
        $attributes = $this->getAttributes();
        $placeholder = isset($this->placeholder) ? 'placeholder="'.$this->placeholder.'"' : '';
        $maxLength = isset($this->maxLength) ? 'maxlength="'.$this->maxLength.'"' : '';
        $pattern = isset($this->pattern) ? 'pattern="'.$this->pattern.'"' : '';
        $label = isset($this->label) ? "<label for=\"{$this->name}\">{$this->label}</label>" : '';

        return "{$label}<input type=\"tel\" name=\"{$this->name}\" wire:model=\"data.{$this->name}\" {$required} {$classes} {$attributes} {$placeholder} {$maxLength} {$pattern}>";
    }
}
