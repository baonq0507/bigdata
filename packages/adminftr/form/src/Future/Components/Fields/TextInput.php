<?php

namespace Adminftr\Form\Future\Components\Fields;

use Adminftr\Form\Future\Components\Field;
use Adminftr\Form\Future\Components\UrlHelper;
use Adminftr\Table\Future\BaseTable;

class TextInput extends Field
{
    public bool $isEmail = false;

    public bool $isPassword = false;

    public $maxLength = null;

    public $pattern = null;

    public $autocomplete = 'on';

    public bool $readOnly = false;

    public bool $disabled = false;

    public ?string $size = null;

    public ?string $step = null;

    public array $action = [];

    public function __construct(string $name, ?string $label = null)
    {
        parent::__construct($name,$label, UrlHelper::getUrl());
    }

    public function email()
    {
        $this->isEmail = true;

        return $this;
    }

    public function password()
    {
        $this->isPassword = true;

        return $this;
    }

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

    public function autocomplete(string $autocomplete)
    {
        $this->autocomplete = $autocomplete;

        return $this;
    }

    public function readOnly(bool $readOnly = true)
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    public function disabled(bool $disabled = true)
    {
        $this->disabled = $disabled;

        return $this;
    }

    public function size(int $size)
    {
        $this->size = $size;

        return $this;
    }

    public function step(float $step)
    {
        $this->step = $step;

        return $this;
    }

    public function render()
    {
        $type = $this->isEmail ? 'email' : ($this->isPassword ? 'password' : 'text');
        $required = $this->isRequired;
        $name = $this->name;
        $classes = $this->classes;
        $attributes = $this->getAttributes();
        $defaultValue = $this->defaultValue;
        $placeholder = $this->placeholder;
        $maxLength = $this->maxLength;
        $pattern = $this->pattern;
        $autocomplete = $this->autocomplete;
        $readOnly = $this->readOnly;
        $disabled = $this->disabled;
        $size = $this->size;
        $step = $this->step;
        $label = $this->label;
        $canHide = $this->canHide;
        $reactive = $this->reactive;
        $action = $this->action;
        $wireModelDirective = $reactive ? 'wire:model.live.debounce.500ms' : 'wire:model';

        return view('form::base.form.textInput',
            compact('canHide', 'type', 'reactive', 'name', 'required', 'classes', 'attributes',
                'defaultValue', 'placeholder', 'maxLength', 'pattern', 'autocomplete',
                'readOnly', 'disabled', 'size', 'step', 'label', 'wireModelDirective', 'action'));
    }

    public function action(string $icon, ?callable $action = null): self
    {
        $this->action = [
            'type' => 'method',
            'icon' => $icon,
            'action' => $action,
        ];

        return $this;
    }

    public function table(string $tile, BaseTable $table): self
    {
        $this->action = [
            'type' => 'table',
            'title' => $tile,
            'table' => $table,
        ];

        return $this;
    }
}
