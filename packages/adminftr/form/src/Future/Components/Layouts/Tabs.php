<?php

namespace Adminftr\Form\Future\Components\Layouts;

class Tabs
{
    protected $classes = '';

    protected $attributes = [];

    protected $tabs = [];

    public function classes(string $classes)
    {
        $this->classes = $classes;

        return $this;
    }

    public function addAttribute(string $name, string $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    public function schema($tab)
    {
        if (!$tab->canHide) {
            if (!($tab instanceof Tab)) {
                $tab = Tab::make()->schema([$tab]);
            }
            $this->tabs[] = $tab;
        }

        return $this;
    }

    public static function make()
    {
        return new static;
    }

    public function render()
    {
        return view('adminftr::future.components.layouts.tab', ['classes' => $this->classes, 'attributes' => $this->attributes, 'tabs' => $this->tabs]);
    }
}
