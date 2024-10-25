<?php

namespace Adminftr\Form\Future\Components\Fields;

use Adminftr\Form\Future\Components\Field;

class RichEditor extends Field
{
    public $plugins = 'advlist autolink lists link image charmap preview anchor pagebreak table code media ';

    public $toolbar = 'undo redo | formatselect | bold italic backcolor  | bullist numlist outdent indent | removeformat | help | table | code | media | form';

    public $height = 500;

    public $menubar = false;

    public $statusbar = true;

    public $readonly = true;

    public $onInit = null;

    public $onChange = null;

    public $onBlur = null;

    public function plugins(string $plugins)
    {
        $this->plugins = $plugins;

        return $this;
    }

    public function toolbar(string $toolbar)
    {
        $this->toolbar = $toolbar;

        return $this;
    }

    public function height(int $height)
    {
        $this->height = $height;

        return $this;
    }

    public function menubar(bool $menubar)
    {
        $this->menubar = $menubar;

        return $this;
    }

    public function statusbar(bool $statusbar)
    {
        $this->statusbar = $statusbar;

        return $this;
    }

    public function readonly(bool $readonly)
    {
        $this->readonly = $readonly;

        return $this;
    }

    public function onInit(callable $onInit)
    {
        $this->onInit = $onInit;

        return $this;
    }

    public function onChange(callable $onChange)
    {
        $this->onChange = $onChange;

        return $this;
    }

    public function onBlur(callable $onBlur)
    {
        $this->onBlur = $onBlur;

        return $this;
    }

    public function render()
    {
        $required = $this->isRequired ? 'required' : '';
        $classes = !empty($this->classes) ? 'form-control ' . $this->classes : 'form-control';
        $attributes = $this->getAttributes();
        $value = $this->defaultValue;
        $name = $this->name;
        $label = $this->label;
        $canHide = $this->canHide;
        $reactive = $this->reactive;
        $plugins = $this->plugins;
        $toolbar = $this->toolbar;
        $height = $this->height;
        $menubar = $this->menubar;
        $statusbar = $this->statusbar;
        $readonly = $this->readonly;
        $onInit = $this->onInit;
        $onChange = $this->onChange;
        $onBlur = $this->onBlur;

        return view('form::base.form.rich-editor',
            compact('required', 'classes', 'reactive',
                'canHide', 'attributes', 'value', 'name', 'label',
                'plugins', 'toolbar', 'height', 'menubar', 'statusbar',
                'readonly', 'onInit', 'onChange', 'onBlur'
            ));
    }
}
