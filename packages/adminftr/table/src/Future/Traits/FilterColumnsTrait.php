<?php

namespace Adminftr\Table\Future\Traits;

use Livewire\Attributes\Url;

trait FilterColumnsTrait
{
    /**
     * The filters applied to the columns.
     *
     * @var array
     */
    #[Url(as: 'f')]
    public $filters = [];

    /**
     * Reset the filters and selected rows.
     *
     * Clears all filters and resets the selected rows.
     *
     * @return void
     */
    public function resetFilters()
    {
        $this->filters = [];
        $this->selectedRows = [];
        return;
    }

    /**
     * Apply filters to the query.
     *
     * Iterates through the filters and applies them to the query.
     * The query is modified to include `where` conditions based on the filters.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyFilters($query)
    {
        foreach ($this->filters as $column => $value) {
            $filterName = $this->getFiltersName($column);
            if ($filterName === null) {
                continue;
            }
            if ($filterName->getOperator() === 'like') {
                $value = '%'.$value.'%';
            }
            if (! empty($value)) {
                $query->where($column, $filterName->getOperator(), $value);
            }
        }
        $this->search = '';
        return $query;
    }

    /**
     * Get the filter object by name.
     *
     * Searches for a filter by its name and returns the filter object.
     * If no filter with the specified name is found, returns null.
     *
     * @param string $name
     * @return \Adminftr\Table\Future\Components\Filters\Filter|null
     */
    protected function getFiltersName($name)
    {
        $filters = $this->filters();
        foreach ($filters as $filter) {
            if ($filter->getName() === $name) {
                return $filter;
            }
        }

        return null;
    }

    /**
     * Define the filters for the columns.
     *
     * Returns an array of filter objects that can be applied to the columns.
     * This method should be overridden in the class using this trait to return the actual filters.
     *
     * @return array
     */
    protected function filters()
    {
        return [];
    }
}
