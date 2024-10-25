<?php

namespace Adminftr\Table\Future\Traits;
use Illuminate\Support\Facades\Concurrency;
/**
 * Trait Columns
 *
 * Provides methods to manage and retrieve column information for a table component.
 */
trait Columns
{
    /**
     * Get the names of non-relation columns.
     *
     * @return array
     */
    protected function getNameColumns()
    {
        $columns = $this->defineColumns();
        $columns = array_map(function ($column) {
            return $column->name;
        }, $columns);

        return array_filter($columns, function ($column) {
            return ! str_contains($column, '.');
        });
    }

    /**
     * Define columns and their visibility.
     *
     * @return array
     */
    protected function defineColumns(): array
    {
        $columns = $this->columns();

        foreach ($columns as $column) {
            $column->visible = $this->columnVisibility[$column->name] ?? $column->visible;
        }

        return $columns;
    }

    /**
     * Abstract method to be implemented by the class using this trait.
     *
     * Returns an array of column definitions.
     *
     * @return array
     */
    abstract protected function columns(): array;

    /**
     * Get the relation columns from the defined columns.
     *
     * @return array
     */
    protected function getRelationColumns()
    {
        $columns = $this->defineColumns();
        $result = [];

        foreach ($columns as $column) {
            $columnName = $column->name;
            if (str_contains($columnName, '.')) {
                [$relation, $col] = explode('.', $columnName);
                $result[] = ['relation' => $relation, 'column' => $col];
            }
        }

        return $result;
    }

    /**
     * Get searchable relation columns.
     *
     * @return array
     */
    protected function getSearchableRelationColumns()
    {
        $columns = $this->defineColumns();
        $columns = array_filter($columns, function ($column) {
            return str_contains($column->name, '.') && $column->searchable;
        });

        return array_map(function ($column) {
            return [
                'relation' => explode('.', $column->name)[0],
                'column' => explode('.', $column->name)[1],
            ];
        }, $columns);
    }

    /**
     * Get searchable non-relation columns.
     *
     * @return array
     */
    protected function getSearchableNonRelationColumns()
    {
        $columns = $this->defineColumns();
        $columns = array_filter($columns, function ($column) {
            return ! str_contains($column->name, '.') && $column->searchable;
        });

        return array_map(function ($column) {
            return $column->name;
        }, $columns);
    }
}
