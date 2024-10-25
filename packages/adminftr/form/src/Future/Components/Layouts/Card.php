<?php

namespace Adminftr\Form\Future\Components\Layouts;

class Card
{
    public $canHide = false;

    protected $title;

    protected $fields = [];

    protected $classes = '';

    protected $headerClasses = '';

    protected $bodyClasses = '';

    protected $footer;

    protected $attributes = [];

    protected $url;

    protected $ribbon;
    protected $subtitle;
    protected $subTitleClasses;

    public static function make(?string $title = null)
    {
        $instance = new static;
        $instance->title = $title;

        return $instance;
    }

    public function classes(string $classes)
    {
        $this->classes = $classes;

        return $this;
    }

    public function headerClasses(string $classes)
    {
        $this->headerClasses = $classes;

        return $this;
    }

    public function bodyClasses(string $classes)
    {
        $this->bodyClasses = $classes;

        return $this;
    }

    public function footer(string $footer)
    {
        $this->footer = $footer;

        return $this;
    }

    public function getFields()
    {
        return $this->fields;

    }

    public function addAttribute(string $name, string $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    public function schema(array $rows)
    {
        foreach ($rows as $row) {
            $this->addField($row);
        }

        return $this;
    }

    public function addField($field)
    {
        $this->fields[] = $field;

        return $this;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function ribbon($icon)
    {
        $this->ribbon = $icon;
    }

    public function subTitle(string $subtitle, string $classes = '')
    {
        $this->subtitle = $subtitle;
        $this->subTitleClasses = $classes;
    }


    public function render()
    {
        return view('form::layouts.card', [
            'title' => $this->title,
            'fields' => $this->fields,
            'classes' => $this->classes,
            'headerClasses' => $this->headerClasses,
            'bodyClasses' => $this->bodyClasses,
            'footer' => $this->footer,
            'attributes' => $this->attributes,
            'url' => $this->url,
            'subtitle' => $this->subtitle,
            'subTitleClasses' => $this->subTitleClasses,
            'ribbon' => $this->ribbon,
        ])->render();
    }
}
