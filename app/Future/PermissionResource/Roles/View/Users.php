<?php

namespace App\Future\PermissionResource\Roles\View;

use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $role;

    public $search = ''; // Thêm biến tìm kiếm nếu cần
    public $selectedUser = null;

    protected $listeners = [
        'deleteRoleUser',
    ];

    public function mount($role)
    {
        $this->role = $role;
    }



    public function deleteRoleUser($id)
    {
        try {
            $this->role->users()->detach($id);
            $this->dispatch('swalSuccess', [
                'message' => 'Xóa người dùng thành công'
            ]);
        }catch (\Exception $exception) {
            $this->dispatch('swalError', [
                'message' => 'Xóa người dùng thất bại'
            ]);
        }
    }

    public function render()
    {
        // Cập nhật truy vấn để hỗ trợ tìm kiếm và phân trang
        $users = $this->role->users()
            ->where('name', 'like', '%'.$this->search.'%')
            ->paginate(10);
        return view('livewire.roles.view.users', compact('users'));
    }
}
