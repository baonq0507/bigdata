<?php

namespace Adminftr\Table\Future\Traits;

use Livewire\Attributes\Url;
use Livewire\WithPagination;

/**
 * Trait PaginationTrait
 *
 * This trait provides pagination functionality for Livewire components.
 * It utilizes Livewire's pagination capabilities and allows dynamic adjustment
 * of items per page.
 */
trait PaginationTrait
{
    use WithPagination;

    /**
     * The number of items to display per page.
     *
     * @var int
     */
    #[Url]
    public int $perPage = 25;
    protected $paginationTheme = 'bootstrap';
    /**
     * The available options for items per page.
     *
     * @var array
     */
    public array $pages = [25, 50, 100, 200, 500];

    /**
     * Resets the page number when the number of items per page is updated.
     *
     * This method is triggered automatically by Livewire when the `perPage`
     * property is updated, ensuring that the current page is reset to 1.
     *
     * @return void
     */
    public function updatingPerPage()
    {
        $this->resetPage();
    }
}
