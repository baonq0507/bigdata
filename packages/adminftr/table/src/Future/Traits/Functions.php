<?php

namespace Adminftr\Table\Future\Traits;

trait Functions
{
    /**
     * Get the listeners for the component.
     *
     * Merges additional listeners with those set in `setListeners()`.
     * Listeners are responsible for handling specific events.
     *
     * @return array
     */
    public function getListeners()
    {
        return array_merge($this->setListeners(), [
            'bulk' => 'bulk',
            'callbackActions' => 'callbackActions',
            'callbackWidgets' => 'callbackWidgets',
        ]);
    }

    /**
     * Set the listeners for the component.
     *
     * Override this method in the class using this trait to add custom listeners.
     *
     * @return array
     */
    protected function setListeners(): array
    {
        return [];
    }

    /**
     * Handle bulk actions.
     *
     * Executes a bulk action on the given data if the action matches the specified name.
     * After the action is performed, dispatches a `reset-select` event.
     *
     * @param mixed $data The data to be processed by the bulk action.
     * @param string $name The name of the bulk action to be executed.
     * @return void
     */
    public function bulk($data, $name): void
    {
        $bulkActions = $this->bulkActions();
        foreach ($bulkActions as $bulkAction) {
            if ($bulkAction->name == $name) {
                call_user_func($bulkAction->callback, $data);
            }
        }
        $this->dispatch('reset-select');
    }

    /**
     * Handle callback actions.
     *
     * Executes a callback action on the model instance identified by the provided data.
     * If the model instance is not found, dispatches an error message.
     *
     * @param mixed $data The data containing the ID of the model.
     * @param string $name The name of the action to be executed.
     * @return void
     */
    public function callbackActions($data, $name)
    {
        $model = $this->model;
        $data = $model::find($data['id']);
        if (! $data) {
            $this->dispatch('swalError', ['message' => 'Không tìm thấy dữ liệu']);

            return;
        }
        $actions = $this->defineActions($data);
        $actions = $actions['actions'];
        foreach ($actions as $action) {
            if ($action->name == $name) {
                if ($action->callbackConfirm) {
                    call_user_func($action->callbackConfirm, $data);
                } else {
                    $this->dispatch('swalError', ['message' => 'Không tìm thấy callback']);
                }
            }
        }
    }

    /**
     * Handle callback widgets.
     *
     * Executes a callback associated with a widget if the widget matches the specified name.
     *
     * @param mixed $data The data to be processed by the widget callback.
     * @param string $name The name of the widget to be executed.
     * @return void
     */
    public function callbackWidgets($data, $name)
    {
        $widgets = $this->defineWidgets();
        foreach ($widgets as $widget) {
            if ($widget->name == $name) {
                call_user_func($widget->callback, $data);
            }
        }
    }

    /**
     * Reset the selection state.
     *
     * Clears all selected rows and unchecks the "select all" checkbox.
     * Dispatches a `reset-select` event to update the UI.
     *
     * @return void
     */
    protected function resetSelect()
    {
        $this->selectAll = false;
        $this->selectedRows = [];
        $this->dispatch('reset-select');
    }
}
