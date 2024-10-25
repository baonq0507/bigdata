<?php

namespace Adminftr\Table\Future;

use Adminftr\Table\Future\Traits\Actions;
use Adminftr\Table\Future\Traits\Can;
use Adminftr\Table\Future\Traits\Columns;
use Adminftr\Table\Future\Traits\ColumnVisibilityTrait;
use Adminftr\Table\Future\Traits\DateRangeTrait;
use Adminftr\Table\Future\Traits\FilterColumnsTrait;
use Adminftr\Table\Future\Traits\Functions;
use Adminftr\Table\Future\Traits\PaginationTrait;
use Adminftr\Table\Future\Traits\SearchTrait;
use Adminftr\Table\Future\Traits\SelectTrait;
use Adminftr\Table\Future\Traits\SortTrait;
use Adminftr\Table\Future\Traits\WidgetsTrait;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Concurrency;
abstract class BaseTable extends Component
{
    use Actions,
        can,
        Columns,
        ColumnVisibilityTrait,
        DateRangeTrait,
        FilterColumnsTrait,
        Functions,
        PaginationTrait,
        SearchTrait,
        SelectTrait,
        SortTrait,
        WidgetsTrait,
        WithFileUploads;

    public array $forms = [];
    public bool $sort = true;
    public string $title;

    public string $description;

    protected string $view = 'future::base-table';

    protected array $select = [];

    protected array $with = [];

    protected string $model;

    /**
     * Initialize the column visibility.
     *
     * This method is called when the component is mounted. It sets the initial visibility
     * of columns based on their default visibility as defined in the `defineColumns` method.
     *
     * @return void
     */
    public function mount()
    {
        foreach ($this->defineColumns() as $column) {
            $columnName = str_replace('.', '_', $column->name);
            $this->columnVisibility[$columnName] = $column->visible;
        }
    }

    public function resetTable(): void
    {
        $this->resetFilters();
        $this->resetFiltersDate();
        $this->resetFiltersSelect();
        $this->search = '';
    }

    public function submitFilter()
    {
        $this->render();
    }
    public function render()
    {
        $this->dispatch('reset-select');
        $data = $this->applyTableQuery()->fastPaginate($this->perPage, pageName: 'page')->onEachSide(1);
        return view($this->view, ['data' => $data]);
    }

    protected function applyTableQuery(): Builder
    {
        $query = $this->query();
        if (!empty(array_filter($this->filters))) {
            $query = $this->applyFilters($query);
        }
        if (!empty(array_filter($this->selectedRows))) {
            $query = $this->SelectedRows($query);
        }
        if (!empty(array_filter($this->dateRangeFilter))) {
            $query = $this->DateRangeFiler($query);
        }

        if ($this->search !== '') {
            $query = $this->applySearch($query);
        }
        if ($this->sortColumn && $this->sortDirection) {
            $query = $query->orderBy($this->sortColumn, $this->sortDirection);
        }

        return $this->afterQuery($query);
    }

    protected function query(): Builder
    {
        $columns = $this->getNameColumns();
        $modelInstance = new $this->model;
        $modelColumns = $modelInstance->getFillable() ?: $columns;
        $diff = array_diff($columns, $modelColumns);

        $this->select = array_unique(array_merge(
            array_diff(array_intersect($this->select, $modelColumns), $diff),
            array_diff($columns, $diff),
            ['id']
        ));

        $with = array_merge(
            array_map(fn($relation) => $relation['relation'], $this->getRelationColumns()),
            $this->with
        );

        return $this->executeQuery($this->select, $with);
    }

    private function executeQuery($select, $with): Builder
    {
        $model = $this->model::query()->select($select);
        if (!empty($with)) {
            $model->with($with);
        }

        return $model;
    }

    protected function afterQuery($query): Builder
    {
        return $query;
    }

    public function boot()
    {
        $actions = $this->actions(new Components\Actions\Actions);
        if ($actions !== null && method_exists($actions, 'forms')) {
            $this->forms = $actions->forms();
        } else {
            $this->forms = [];
        }
        $headerForms = collect($this->headerActions())->filter(function ($headerAction) {
            return isset($headerAction->modal) && $headerAction->modal;
        })->map(function ($headerAction) {
            return ['form' => $headerAction->form, 'name' => $headerAction->name, 'label' => $headerAction->label, 'type' => $headerAction->type];
        })->toArray();
        $this->forms = array_merge($this->forms, $headerForms);
    }
}
