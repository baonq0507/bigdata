<?php

namespace Adminftr\Table\Future\Traits;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Session;
use Livewire\Attributes\Url;

/**
 * Trait SearchTrait
 *
 * This trait provides search functionality for Livewire components.
 * It allows for searching across specified columns and handles
 * search queries both in the main and related models.
 */
trait SearchTrait
{
    /**
     * The search query string.
     *
     * @var string
     */
    #[Session]
    #[Url(as: 's')]
    public $search = '';

    /**
     * The array of additional searchable columns.
     *
     * @var array
     */
    protected array $searchable = [];

    /**
     * Reset the page number when the search query is updated.
     *
     * This method is triggered automatically by Livewire whenever
     * the `search` property is updated, ensuring that the pagination
     * starts from the first page.
     *
     * @return void
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Apply the search query to the given query builder.
     *
     * This method modifies the query to filter results based on the
     * search query. It supports searching in both the main model
     * and related models.
     *
     * @param Builder $query
     * @return Builder
     */
    protected function applySearch($query)
    {

        $searchColumns = $this->getSearchableNonRelationColumns();
        $relationColumns = $this->getSearchableRelationColumns();
        $searchable = array_merge($searchColumns, $this->searchable);
        $searchable = array_unique($searchable);
        $query->where(function ($subQuery) use ($searchable, $relationColumns) {
            foreach ($searchable as $column) {
                $subQuery->orWhere($column, 'like', '%' . $this->search . '%');
            }

            if (!empty($relationColumns)) {
                foreach ($relationColumns as $relationColumn) {
                    $subQuery->orWhereHas($relationColumn['relation'], function ($query) use ($relationColumn) {
                        $query->where($relationColumn['column'], 'like', '%' . $this->search);
                    });
                }
            }
        });

        return $query;
    }
}
