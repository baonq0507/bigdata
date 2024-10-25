<?php

namespace Adminftr\Form\Future;

use Exception;
use Adminftr\Form\Future\Components\Form;
use Adminftr\Form\Future\Components\UrlHelper;
use Adminftr\Form\Future\Traits\DataInitializationTrait;
use Adminftr\Form\Future\Traits\DataPersistenceTrait;
use Adminftr\Form\Future\Traits\DataValidationTrait;
use Adminftr\Form\Future\Traits\FieldExtractionTrait;
use Adminftr\Form\Future\Traits\NotificationTrait;
use Adminftr\Form\Future\Traits\SearchDataTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Abstract class BaseForm
 *
 * This class serves as a base form component for handling form data, validation,
 * persistence, and other common form-related functionalities.
 */
abstract class BaseForm extends Component
{
    use DataInitializationTrait,
        DataPersistenceTrait,
        DataValidationTrait,
        FieldExtractionTrait,
        NotificationTrait,
        WithFileUploads,
        SearchDataTrait;

    /**
     * @var int|null $id The ID of the form, locked to prevent changes.
     */
    #[Locked]
    public $id = null;

    /**
     * @var array $data The form data.
     */
    public array $data = [];

    /**
     * @var array $relations The form relations.
     */
    public array $relations = [];

    /**
     * @var string $url The URL associated with the form, locked to prevent changes.
     */
    #[Locked]
    public $url;

    /**
     * @var Form $form The form instance, locked to prevent changes.
     */
    #[Locked]
    protected $form;

    /**
     * @var Model $model The model associated with the form.
     */
    protected $model;

    /**
     * @var string $view The view file for rendering the form.
     */
    protected string $view = 'form::base-form';

    /**
     * Initialize the form data.
     */
    public function mount()
    {
        $this->initializeData($this->getInputFields());
    }

    /**
     * Boot the form with the given Form instance.
     *
     * @param Form $form The form instance.
     */
    public function boot(Form $form)
    {
        UrlHelper::setUrl($this->url);
        $this->form = $this->form($form);
    }

    /**
     * Abstract method to define the form structure.
     *
     * @param Form $form The form instance.
     * @return mixed
     */
    abstract public function form(Form $form);

    /**
     * Handle updates to form properties.
     *
     * @param string $property The updated property.
     */
    public function updated($property)
    {
        $this->afterStateUpdated($property);
    }

    /**
     * Perform actions after a form property is updated.
     *
     * @param string $property The updated property.
     */
    protected function afterStateUpdated($property)
    {
        $this->skipRender();
        foreach ($this->getInputFields() as $input) {
            if ($input->afterStateUpdated && 'data.' . $input->name == $property) {
                $this->data = call_user_func($input->afterStateUpdated, $this->data);
            }
        }
    }

    /**
     * Save the form data.
     */
    public function save()
    {
        DB::beginTransaction();
        if (!empty($this->rules())) {
            $this->validate();
        }
        try {
            $url = $this->url;
            if (str_contains($url, 'edit')) {
                $this->data = $this->beforeUpdate($this->data);
            } else {
                $this->data = $this->beforeSave($this->data);
            }
            $this->persistData();
            if (function_exists('afterSave')) {
                return $this->afterSave($this->data);
            }
            DB::commit();
            $this->notificationOk('Save success');
            $this->dispatch('form-saved');
        } catch (Exception $e) {
            DB::rollBack();
            $this->notificationError($e->getMessage());
        }
    }

    /**
     * Hook to modify data before updating.
     *
     * @param array $data The form data.
     * @return array The modified data.
     */
    protected function beforeUpdate(array $data)
    {
        return $data;
    }

    /**
     * Hook to modify data before saving.
     *
     * @param array $data The form data.
     * @return array The modified data.
     */
    protected function beforeSave(array $data)
    {
        return $data;
    }

    /**
     * Execute actions associated with a specific input.
     *
     * @param string $name The name of the input.
     */
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

    /**
     * Execute actions associated with a specific method.
     *
     * @param string $name The name of the method.
     */
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

    /**
     * Get the list of actions.
     *
     * @return array The list of actions.
     */
    protected function Actions()
    {
        return [];
    }

    /**
     * Render the form view.
     *
     * @return \Illuminate\View\View The form view.
     */
    public function render()
    {
        return view($this->view);
    }
}
