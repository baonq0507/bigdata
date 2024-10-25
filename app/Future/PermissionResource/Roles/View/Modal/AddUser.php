<?php
namespace App\Future\PermissionResource\Roles\View\Modal;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AddUser extends Component
{
    use WithPagination;
    public $searchUser = '';
    public $role;
    public $selectedUserName = '';
    public $selectedUser = null;

    public function mount($role)
    {
        $this->role = $role;
    }

    public function selectUser($userId, $userName)
    {
        $this->selectedUser = $userId;
        $this->selectedUserName = $userName;
    }

    public function saveUser()
    {
        try {
            if ($this->selectedUser) {
                $this->role->users()->attach($this->selectedUser);
                $this->selectedUser = null;
                $this->selectedUserName = '';
            }
            $this->dispatch('swalSuccess', [
                'message' => 'Thêm người dùng thành công'
            ]);
        }catch (\Exception $exception) {
            $this->dispatch('swalError', [
                'message' => 'Thêm người dùng thất bại'
            ]);
        }
    }

    public function render(){
        $users = User::where('name', 'like', '%'.$this->searchUser.'%')->paginate(10);
        return view('livewire.roles.view.modal.add-user',compact('users'));
    }
}
