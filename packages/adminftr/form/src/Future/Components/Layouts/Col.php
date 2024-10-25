<?php

namespace Adminftr\Form\Future\Components\Layouts;

class Col
{
    public $canHide = false;

    protected $classes = '';

    protected $attributes = [];

    protected $content;

    public static function make()
    {
        return new static;
    }

    public function classes(string $classes)
    {
        $this->classes = $classes;

        return $this;
    }

    public function addClasses(string $classes)
    {
        $this->classes .= " $classes";

        return $this;
    }

    public function addAttribute(string $name, string $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    public function schema(array $content)
    {
        $this->content = $content;

        return $this;
    }

    public function col(int $value)
    {
        $this->classes .= " col-$value";

        return $this;
    }

    public function md(int $value)
    {
        $this->classes .= " col-md-$value";

        return $this;
    }

    public function sm(int $value)
    {
        $this->classes .= " col-sm-$value";

        return $this;
    }

    public function lg(int $value)
    {
        $this->classes .= " col-lg-$value";

        return $this;
    }

    public function getField()
    {
        return $this->content;

    }

    public function render()
    {
        $htmlRender = '';
        foreach ($this->content as $content) {
            if (!$content->canHide) {
                if(!empty($content->col)){
                   $this->classes = '';
                    $this->classes .= " col-{$content->col['sm']} col-md-{$content->col['md']} col-lg-{$content->col['lg']} mt-2";
                }
                $html = '<div class="' . $this->classes . '"';
                foreach ($this->attributes as $name => $value) {
                    $html .= ' ' . $name . '="' . $value . '"';
                }
                $html .= '>';
                $html .= $content->render();
                $html .= '</div>';

                $htmlRender .= $html;
            }
        }

        return $htmlRender;

    }
}
