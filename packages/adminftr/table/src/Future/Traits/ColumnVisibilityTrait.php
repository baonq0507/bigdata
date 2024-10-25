<?php

namespace Adminftr\Table\Future\Traits;

/**
 * Trait ColumnVisibilityTrait
 *
 * This trait is used to handle column visibility in Livewire components.
 */
trait ColumnVisibilityTrait
{
    /**
     * The visibility of each column.
     *
     * @var array
     */
    public $columnVisibility = [];



    /**
     * Update the visibility of a column.
     *
     * This method is called when a column's visibility is updated. It converts the column name
     * from the format used in the visibility array (with underscores) back to the format used
     * in the column definitions (with dots).
     *
     * @param bool $value The visibility value (true for visible, false for hidden).
     * @param string $column The name of the column, with underscores instead of dots.
     *
     * @return void
     */
    public function updatedColumnVisibility($value, $column)
    {
        $column = str_replace('_', '.', $column);
        $this->columnVisibility[$column] = $value;
    }
}
