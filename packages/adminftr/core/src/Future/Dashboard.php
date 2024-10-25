<?php

namespace Adminftr\Core\Future;

use Livewire\Component;

class Dashboard extends Component
{
    public string $dateStart = '';

    public string $dateEnd = '';

    public function mount()
    {
        $this->dateStart = now()->subDays(7)->format('Y-m-d');
        $this->dateEnd = now()->format('Y-m-d');
    }

    public function filter() {}

    public function render()
    {
        $widgets = $this->getWidgets();
        return view('future::future.dashboard', compact('widgets'));
    }

    protected function getWidgets()
    {
        return config('future.future.dashboard.widgets');
    }
}
