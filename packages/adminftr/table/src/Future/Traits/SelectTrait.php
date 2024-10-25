<?php

namespace Adminftr\Table\Future\Traits;

use Adminftr\Table\Future\Components\Filters\SelectFilter;
use Livewire\Attributes\Url;

/**
 * Trait SelectTrait
 *
 * This trait is used to handle row selection in Livewire components.
 */
trait SelectTrait
{
    /**
     * Indicates if all rows are selected.
     *
     * @var bool
     */
    public $selectAll = false;

    /**
     * The selected rows.
     *
     * @var array
     */
    #[Url(as: 'se')]
    public $selectedRows = [];

    public function resetFiltersSelect()
    {
        foreach ($this->selectedRows as $column => $value) {
            $this->selectedRows[$column] = '';
        }
    }

    public function filterSelect($value, $field)
    {
        $this->skipRender();
        foreach ($this->getSelectFilter() as $filter) {
            if ($filter->getName() == $field) {
                return $filter->search($value)->options;
            }
        }
        return [];
    }

    protected function getSelectFilter()
    {
        $filters = [];
        foreach ($this->filters() as $filter) {
            if ($filter instanceof SelectFilter) {
                $filters[] = $filter;
            }
        }
        return $filters;
    }

    protected function SelectedRows($query)
    {
        foreach ($this->selectedRows as $column => $value) {
            if (!empty($value)) {
                $query->where($column, $value);
            }
        }

        return $query;
    }
}
