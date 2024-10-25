<?php

namespace Adminftr\Table\Future\Components\BulkActions;

class BulkAction
{
    public string $name;

    public string $title;

    public ?string $icon;

    public $callback;

    public string $question;

    public ?string $labelYes = 'Yes';

    public ?string $labelNo = 'No';

    public ?string $type = 'primary';

    public function __construct(string $name, string $title, ?string $icon, string $question)
    {
        $this->name = $name;
        $this->title = $title;
        $this->icon = $icon;
        $this->question = $question;
    }

    public static function make(string $name, string $title, ?string $icon, string $question): self
    {
        return new self($name, $title, $icon, $question);
    }

    public function callback($callback): self
    {
        $this->callback = $callback;

        return $this;
    }

    public function setLabelYes(string $labelYes): self
    {
        $this->labelYes = $labelYes;

        return $this;
    }

    public function setLabelNo(string $labelNo): self
    {
        $this->labelNo = $labelNo;

        return $this;
    }

    public function render()
    {
        return view('future::base.actions.bulk-actions', [
            'name' => $this->name,
            'title' => $this->title,
            'icon' => $this->icon,
            'question' => $this->question,
            'labelYes' => $this->labelYes,
            'labelNo' => $this->labelNo,
            'type' => $this->type,
        ]);
    }
}
