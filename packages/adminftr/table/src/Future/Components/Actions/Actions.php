<?php

namespace Adminftr\Table\Future\Components\Actions;

use Illuminate\Database\Eloquent\Model;

class Actions
{
    /**
     * @var Action[]
     */
    public array $actions = [];

    public $forms = [];

    public ?Model $data = null;

    private string $renderMethodButton = 'renderAsButtons';

    private string $renderMethod = 'renderAsDropdown';

    public static function create(array $actions, string $renderMethod = 'renderAsDropdown'): self
    {

        $instance = new static();
        $instance->actions = $actions;
        $instance->renderMethod = $renderMethod;

        return $instance;
    }

    public function schema()
    {
        $actions = $this->actions;
        foreach ($actions as $action) {
            $action->data($this->data);
            if ($action->form) {
                $this->form($action->form, $action->name, $action->label, $action->type);
            }
        }

        return $this;
    }

    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    public function form($form, $name, $label,$type): void
    {
        $this->forms[] = ['form' => $form, 'name' => $name, 'label' => $label, 'type' => $type];
    }

    public function forms()
    {
        $action = $this->actions;
        foreach ($action as $act) {
            if ($act->form) {
                $this->form($act->form, $act->name, $act->label, $act->type);
            }
        }

        return $this->forms;
    }

    public function render()
    {
        return $this->{$this->renderMethod}();
    }

    protected function renderAsButtons()
    {
        return view('future::base.buttons', ['actions' => $this->actions, 'data' => $this->data]);
    }

    protected function renderAsDropdown()
    {
        return view('future::base.dropdown', ['actions' => $this->actions, 'data' => $this->data]);
    }
}
