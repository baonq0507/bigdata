<?php

namespace Adminftr\Form\Future\Components\Fields;

use Adminftr\Form\Future\Components\Field;

class CheckboxGroup extends Field
{
    public array $options = [];
    public bool $multiple = false;

    public function options(array $options)
    {
        $this->options = $options;
        return $this;
    }

    public function render()
    {
        $required = $this->isRequired ? 'required' : '';
        $classes = !empty($this->classes) ? 'form-check-input ' . $this->classes : 'form-check-input';
        $attributes = $this->getAttributes();
        $checked = $this->defaultValue ? 'checked' : '';
        $name = $this->name;
        $label = $this->label;
        $canHide = $this->canHide;
        $options = $this->options;
        $multiple = $this->multiple;
        $reactive = $this->reactive;

        // Group options by their group key
        $groupedOptions = [];
        $ungroupedOptions = [];
        foreach ($options as $key => $option) {
            if (isset($option['group'])) {
                $group = $option['group'];
                $groupedOptions[$group][$key] = $option;
            } else {
                $ungroupedOptions[$key] = $option;
            }
        }

        return view('form::base.form.checkbox-group',
            compact('required', 'classes', 'groupedOptions', 'ungroupedOptions', 'multiple', 'reactive',
                'canHide', 'attributes', 'checked', 'name', 'label'
            ));
    }
}
