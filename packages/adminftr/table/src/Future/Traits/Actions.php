<?php

namespace Adminftr\Table\Future\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait Actions
 *
 * Provides methods to define and manage actions for a table component.
 */
trait Actions
{
    /**
     * Define actions for the table.
     *
     * @param Model|null $data
     * @return \Illuminate\Support\HtmlString
     */
    protected function defineActions(?Model $data = null)
    {
        return $this->actions(new \Adminftr\Table\Future\Components\Actions\Actions())->data($data)->schema()->render();
    }

    /**
     * Abstract method to be implemented by the class using this trait.
     *
     * Defines the actions for the table.
     *
     * @param \Adminftr\Table\Future\Components\Actions\Actions $actions
     * @return mixed
     */
    abstract protected function actions(\Adminftr\Table\Future\Components\Actions\Actions $actions);

    /**
     * Get the actions defined for the table.
     *
     * @return mixed
     */
    protected function getActions()
    {
        return $this->actions(new \Adminftr\Table\Future\Components\Actions\Actions());
    }

    /**
     * Define header actions for the table.
     *
     * @return array
     */
    protected function headerActions(): array
    {
        return [];
    }

    /**
     * Define filters for the table.
     *
     * @return array
     */
    protected function defineFilters(): array
    {
        return $this->filters();
    }

    /**
     * Define bulk actions for the table.
     *
     * @return array
     */
    protected function bulkActions(): array
    {
        return [];
    }
}
