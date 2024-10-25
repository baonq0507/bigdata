<?php

namespace Adminftr\Form\Future;

use Exception;
use Adminftr\Form\Future\Components\Form;
use Adminftr\Form\Future\Traits\DataInitializationTrait;
use Adminftr\Form\Future\Traits\DataPersistenceTrait;
use Adminftr\Form\Future\Traits\DataValidationTrait;
use Adminftr\Form\Future\Traits\FieldExtractionTrait;
use Adminftr\Form\Future\Traits\NotificationTrait;
use Adminftr\Form\Future\Traits\SearchDataTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

abstract class BaseModal extends Component
{
    use DataInitializationTrait,
        DataPersistenceTrait,
        DataValidationTrait,
        FieldExtractionTrait,
        NotificationTrait,
        WithFileUploads,
        SearchDataTrait;

    #[Locked]
    public  $id;

    public  $title;

    public  $name;

    public array $data = [];

    protected  $form;

    protected  $model;
    public string $type;



    public function mount(?string $id = null, ?string $title = null, ?string $name = null, ?string $type = "edit")
    {
        $this->id = $id;
        $this->title = $title;
        $this->name = $name;
        $inputs = $this->getInputFields();
        $this->initializeData($inputs);
        $this->type = $type;
    }

    public function boot()
    {
        $this->form = $this->form(new Form());
    }
    #[On('setModel')]
    public function setData($id)
    {
        $this->id = $id;
        $inputs = $this->getInputFields();
        $this->initializeData($inputs);
    }

    public function save()
    {
        $this->skipRender();
        DB::beginTransaction();
        try {
            if(!empty($this->rules())){
                $this->validate($this->rules(),$this->messages());
            }
            if ($this->id) {
                $this->data = $this->beforeUpdate($this->data);
            } else {
               $this->data = $this->beforeSave($this->data);
            }

            if (method_exists($this, 'afterSave')) {
                $this->afterSave($this->data);
            }
            if (method_exists($this, 'afterUpdate')) {
                $this->afterUpdate($this->data);
            }
            $this->persistData();
            if (function_exists('afterSave')) {
                return $this->afterSave($this->data);
            }
            DB::commit(); // Hoàn thành transaction

            $this->notificationOk('Save success');
        } catch (Exception $e) {
            DB::rollBack(); // Hoàn tác các thay đổi nếu có lỗi
            $this->notificationError($e->getMessage());
        }

        $this->dispatch('refreshTable');
    }

    protected function beforeSave(array $data)
    {
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        return $data;
    }

    public function inputActions($name)
    {
        $this->skipRender();
        $inputs = $this->getInputFields();
        foreach ($inputs as $input) {
            if ($input->name == $name) {
                call_user_func($input->action['action'], $this);
            }
        }
    }

    public function methodActions($name)
    {
        $this->skipRender();
        $actions = $this->Actions();
        foreach ($actions as $action) {
            if ($action->name == $name) {
                call_user_func($action->callback, $this);
            }
        }
    }
    abstract public function form(Form $form);

    public function render()
    {
        return view('form::modal-form', ['inputs' => $this->form(new Form())->render()]);
    }
}
