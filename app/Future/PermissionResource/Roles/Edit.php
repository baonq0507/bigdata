<?php

namespace App\Future\PermissionResource\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public $roleId;
    public $roleName;
    public $selectedPermissions = [];

    protected $listeners = ['editRole' => 'loadRole'];

    public function loadRole($id)
    {
        $this->roleId = $id;
        $role = Role::findById($id);
        $this->roleName = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->dispatch('show-update-role-modal');
    }

    public function render()
    {
        $permissionsGroupedByModule = $this->getGroupedPermissions();
        return view('livewire.roles.edit', compact('permissionsGroupedByModule'));
    }

    private function getGroupedPermissions()
    {
        $permissions = Permission::all()->sortBy(function ($permission) {
            return explode('.', $permission->name, 2)[0];
        });

        return $permissions->groupBy(function ($permission) {
            return explode('.', $permission->name, 2)[0];
        });
    }

    public function updateRole()
    {
        $this->validate([
            'roleName' => 'required|string|max:255',
            'selectedPermissions' => 'required|array'
        ]);

        $role = Role::findById($this->roleId);
        $role->name = $this->roleName;
        $role->save();

        $role->syncPermissions($this->selectedPermissions);

        // Thêm thông báo hoặc hành động sau khi cập nhật thành công
       $this->dispatch('hide-update-role-modal');
       $this->dispatch('showToast', [
            'type' => 'success',
            'message' => 'Role updated successfully.'
        ]);
    }
}
