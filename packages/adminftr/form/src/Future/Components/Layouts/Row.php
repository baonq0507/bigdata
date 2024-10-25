<?php

namespace Adminftr\Form\Future\Components\Layouts;

class Row
{
    public $canHide = false;
    protected $classes = '';
    protected $attributes = [];
    protected $cols = [];
    protected $defaultColClasses = '';
    protected $url;

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

    public function addCol($col)
    {
        if (!$col->canHide) {
            if (!($col instanceof Col)) {
                $col = Col::make()->schema([$col]);
                $col->addClasses($this->defaultColClasses);
            }
            $this->cols[] = $col;
        }

        return $this;
    }

    public function schema(array $cols)
    {
        foreach ($cols as $col) {
            $this->addCol($col);
        }

        return $this;
    }

    public static function make($sm = 12, $md = 12, $lg = 12)
    {
        $instance = new static;
        $instance->defaultColClasses = "col-sm-$sm col-md-$md col-lg-$lg mb-3";

        return $instance;
    }

    public function getFields()
    {
        $fields = [];
        foreach ($this->cols as $col) {
            $fields = array_merge($fields, $col->getField());
        }

        return $fields;
    }

    public function render()
    {
        $html = '<div class="row ' . $this->classes . '"';
        foreach ($this->attributes as $name => $value) {
            $html .= ' ' . $name . '="' . $value . '"';
        }
        $html .= '>';
        foreach ($this->cols as $col) {
            $html .= $col->render();
        }
        $html .= '</div>';

        return $html;
    }
}
