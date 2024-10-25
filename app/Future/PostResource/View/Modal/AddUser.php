<?php
namespace App\Future\PostResource\View\Modal;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AddUser extends Component
{
    use WithPagination;

    public function render()
    {
        $users = User::where('name', 'like', '%'.$this->searchUser.'%')->paginate(10);
        return view('livewire.roles.view.modal.add-user',compact('users'));
    }
}
