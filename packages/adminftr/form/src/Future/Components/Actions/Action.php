<?php

namespace Adminftr\Form\Future\Components\Actions;

class Action
{
    public string $name;

    public string $label;

    public ?string $icon = null;

    public string $color = 'primary';

    public ?array $confirm = null;

    public bool $hidden = true;

    public $callback;

    public $confirmCallback;

    public function __construct(string $name, string $label, ?string $icon = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->icon = $icon;
    }

    public static function make(string $name, string $label, ?string $icon = null): self
    {
        return new static($name, $label, $icon);
    }

    public function color(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function canSee(callable|bool $callback): self
    {
        if (is_callable($callback)) {
            $this->hidden = $callback();
        } elseif (is_bool($callback)) {
            $this->hidden = $callback;
        }

        return $this;
    }

    public function action(callable $callback): self
    {
        $this->callback = $callback;

        return $this;
    }

    public function confirm(string $title, string $text, callable $callback): self
    {
        $this->confirm = [
            'title' => $title,
            'text' => $text,
        ];
        $this->confirmCallback = $callback;

        return $this;
    }

    public function render()
    {
        return view('form::base.form.actions.action', ['action' => $this]);
    }
}
