<?php

namespace Adminftr\Form\Future\Components\Fields;

use Adminftr\Form\Future\Components\UrlHelper;

class Text
{
    public bool $canHide = false;

    protected string $name;

    protected string $tag = 'p'; // CSS classes

    protected string $classes = ''; // Additional attributes

    protected array $attributes = []; // HTML ID attribute

    protected string $id = ''; // Placeholder attribute

    protected string $placeholder = '';

    protected string $beforeText = '';

    protected string $afterText = '';

    protected string $colorClass = '';

    protected string $link = '';

    protected string $beforeValue = '';
    protected string $afterValue = '';

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function make(string $name): self
    {
        return new static($name);
    }

    public function tag(string $tag)
    {
        $this->tag = $tag;

        return $this;
    }

    public function name(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function classes(string $classes)
    {
        $this->classes = $classes;

        return $this;
    }

    public function attributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function id(string $id)
    {
        $this->id = $id;

        return $this;
    }

    public function link(string $link)
    {
        $this->link = $link;

        return $this;
    }

    public function placeholder(string $placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function hide(callable $callback): self
    {
        if ($callback()) {
            $this->canHide = true;
        }

        return $this;
    }

    public function canUpdate($hide)
    {
        $currentRouteName = UrlHelper::getUrl();
        if (str_contains($currentRouteName, 'edit')) {
            $this->canHide = !$hide;
        }

        return $this;
    }

    public function color(string $colorClass)
    {
        $this->colorClass = $colorClass;

        return $this;
    }

    public function canStore($hide)
    {
        $currentRouteName = UrlHelper::getUrl();
        if (str_contains($currentRouteName, 'create')) {
            $this->canHide = !$hide;
        }

        return $this;
    }

    public function render()
    {
        $this->trimSpaces();

        return view('form::base.form.text', [
            'tag' => $this->tag,
            'name' => $this->name,
            'classes' => $this->classes,
            'attributes' => $this->attributes,
            'id' => $this->id,
            'link' => $this->link,
            'beforeValue' => is_callable($this->beforeValue) ? ($this->beforeValue)() : $this->beforeValue,
            'afterValue' => is_callable($this->afterValue) ? ($this->afterValue)() : $this->afterValue,
            'placeholder' => $this->placeholder,
            'beforeText' => is_callable($this->beforeText) ? ($this->beforeText)() : $this->beforeText,
            'afterText' => is_callable($this->afterText) ? ($this->afterText)() : $this->afterText,
            'colorClass' => $this->colorClass,
        ]);
    }

    protected function trimSpaces()
    {
        $this->name = trim($this->name);
        $this->id = trim($this->id);
        $this->placeholder = trim($this->placeholder);
        $this->beforeText = trim($this->beforeText);
        $this->afterText = trim($this->afterText);
        $this->link = trim($this->link);
    }

    public function beforeText($content)
    {
        if (is_callable($content)) {
            $this->beforeText = $content();
        } else {
            $this->beforeText = $content;
        }

        return $this;
    }

    public function afterText($content)
    {
        if (is_callable($content)) {
            $this->afterText = $content();
        } else {
            $this->afterText = $content;
        }

        return $this;
    }

    public function beforeValue($content)
    {
        if (is_callable($content)) {
            $this->beforeValue = $content();
        } else {
            $this->beforeValue = $content;
        }

        return $this;
    }

    public function afterValue($content)
    {
        if (is_callable($content)) {
            $this->afterValue = $content();
        } else {
            $this->afterValue = $content;
        }

        return $this;
    }
}
