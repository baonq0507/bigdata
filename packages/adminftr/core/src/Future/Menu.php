<?php

namespace Adminftr\Core\Future;

use Livewire\Attributes\Lazy;
use Livewire\Component;
#[Lazy]
class Menu extends Component
{
    public $menu;

    public function mount()
    {
        $excludedPatterns = ['login', 'logout', 'register', 'forgot'];
        $query = \Adminftr\Core\Http\Models\Menu::query();

        foreach ($excludedPatterns as $pattern) {
            $query->where('url', 'not like', '%'.$pattern.'%');
        }

        $menus = $query->orderBy('visitor','desc')->get();

        if ($menus->isNotEmpty()) {
            $maxVisitors = $menus->first()->visitor; // Lượng truy cập lớn nhất
            $minVisitors = $menus->last()->visitor;  // Lượng truy cập nhỏ nhất

            foreach ($menus as $menu) {
                $menu->progress = $maxVisitors > 0 ? (($menu->visitor - $minVisitors) / ($maxVisitors - $minVisitors) * 100) : 0;
            }
        }

        $this->menu = $menus;
    }

    public function render()
    {
        return view('future::future.menu');
    }
}
