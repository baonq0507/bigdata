<?php

namespace Adminftr\Widgets\Future;

use Closure;

class Stat extends Widget
{

    public string $color = 'primary';

    public $callback;

    public string $title;

    public string $description = '';

    public array $subDescription = [];

    public $value;

    public array $dropdown = [];

    public bool $isHover = false;

    public string $dateStart = '';

    public string $dateEnd = '';

    public function __construct(string $title, string|callable $value = '')
    {
        $this->title = $title;
        $this->value = $value;
    }

    public static function __set_state($properties)
    {
        $stat = new self($properties['title'], $properties['value']);
        foreach ($properties as $property => $value) {
            $stat->$property = $value;
        }
        return $stat;
    }


    public static function make(string $title, string|callable $value = ''): self
    {
        return new self($title, $value);
    }

    public function color($color)
    {
        $this->color = $color;

        return $this;
    }

    public function callback(Closure $callback)
    {
        $this->callback = function ($startDate = '', $endDate = '') use ($callback) {
            $callback($this, $startDate, $endDate);
        };

        return $this;
    }

    public function description(string $description='')
    {
        $this->description = $description;

        return $this;
    }

    public function subDescription($color, $title, $icon)
    {
        $this->subDescription = [
            'color' => $color,
            'title' => $title,
            'icon' => $icon,
        ];

        return $this;
    }

    public function dateRange($start, $end)
    {
        $this->dateStart = $start;
        $this->dateEnd = $end;

        return $this;
    }

    public function isHover()
    {
        $this->isHover = true;

        return $this;
    }

    public function dropdown(string $title, array $items)
    {
        $this->dropdown = [
            'title' => $title,
            'items' => $items,
        ];

        return $this;
    }

    public function render()
    {
        if (is_callable($this->callback)) {
            call_user_func($this->callback, $this->dateStart, $this->dateEnd);
        }

        if (is_callable($this->value)) {
            $this->value = call_user_func($this->value);
        }

        return view('widget::stat', [
            'data' => $this,
        ]);
    }
}
