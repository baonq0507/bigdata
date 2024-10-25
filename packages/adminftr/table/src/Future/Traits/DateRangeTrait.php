<?php

namespace Adminftr\Table\Future\Traits;

use Livewire\Attributes\Url;

trait DateRangeTrait
{
    /**
     * The selected date range filters.
     *
     * @var array
     */
    #[Url(as: 'd')]
    public $dateRangeFilter = [];

    /**
     * Reset the date range filters to empty.
     *
     * This method clears all date range filters by setting their values to empty strings.
     *
     * @return void
     */
    public function resetFiltersDate()
    {
        foreach ($this->dateRangeFilter as $column => $value) {
            $this->dateRangeFilter[$column] = '';
        }
        return;
    }

    /**
     * Apply date range filters to a query.
     *
     * This method modifies the given query based on the date range filters. It uses
     * the `whereBetween` clause if both start and end dates are provided. If only a
     * start date is provided, it uses the `whereDate` clause.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query The query builder instance.
     *
     * @return \Illuminate\Database\Eloquent\Builder The modified query builder instance.
     */
    public function DateRangeFiler($query)
    {
        foreach ($this->dateRangeFilter as $column => $value) {
            if (! empty($value)) {
                $dateArray = explode(' to ', $this->dateRangeFilter[$column]);
                $startDate = $dateArray[0];
                if (isset($dateArray[1])) {
                    $query->whereBetween($column, [$startDate, $dateArray[1]]);
                } else {
                    $query->whereDate($column, $startDate);
                }
            }
        }

        return $query;
    }
}
