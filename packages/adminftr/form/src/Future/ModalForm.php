<?php

namespace Adminftr\Form\Future;

use Adminftr\Form\Future\Components\Form;
use Adminftr\Form\Future\Traits\NotificationTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

abstract class ModalForm extends Component
{
    use NotificationTrait;

    #[Locked]
    public $id;

    public $title;

    public $name;

    public array $data = [];

    protected $form;

    protected $model;

    public bool $readOnly = false;

    public function mount(?string $id = null, ?string $title = null, ?string $name = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->name = $name;
        if ($this->id) {
            $this->model = $this->model::find($this->id);
            $this->data = $this->model->toArray();
        }
    }

    #[On('setModel')]
    public function setData($id)
    {
        $this->id = $id;
        if ($this->id) {
            $this->model = $this->model::find($this->id);
            $this->data = $this->model->toArray();
        } else {
            $this->data = [];
        }
        //        $this->skipRender();
    }

    public function save()
    {
        if (method_exists($this, 'rules')) {
            $this->validate();
        }

        DB::beginTransaction();
        try {
            if (method_exists($this, 'beforeSave')) {
                $this->data = $this->beforeSave($this->data);
            }

            if ($this->id) {
                $model = $this->model::find($this->id);
                if ($model) {
                    $model->update($this->data);
                    $this->data = $model->toArray();
                } else {
                    throw new Exception('Record not found.');
                }
            } else {
                $this->model::create($this->data);
            }

            if (method_exists($this, 'afterSave')) {
                $this->afterSave($this->data);
            }

            DB::commit(); // Hoàn thành transaction

            $this->notificationOk('Save success');
        } catch (Exception $e) {
            DB::rollBack(); // Hoàn tác các thay đổi nếu có lỗi
            $this->notificationError($e);
        }

        $this->dispatch('refreshTable');
    }

    protected function notificationOk($message)
    {
        $this->dispatch('swalSuccess', ['message' => $message]);
    }

    protected function notificationError($message)
    {
        $this->dispatch('swalError', ['message' => $message]);
    }

    public function rules()
    {
        if (method_exists($this, 'form')) {
            return $this->form(new Form())->getRules();
        }

        return [];
    }

    abstract public function form(Form $form);

    public function render()
    {
        return view('form::modal-form', ['inputs' => $this->form(new Form())->render(), 'readOnly' => $this->readOnly]);
    }
}
